// websocket/server.php (run as daemon)
<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class ProjectChat implements MessageComponentInterface {
    protected $clients;
    protected $projects;
    
    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->projects = [];
    }
    
    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        $query = $conn->httpRequest->getUri()->getQuery();
        parse_str($query, $params);
        $projectId = $params['project'] ?? 0;
        $this->projects[$conn->resourceId] = $projectId;
    }
    
    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);
        $projectId = $this->projects[$from->resourceId] ?? 0;
        
        // Save to DB
        $db = db();
        $stmt = $db->prepare("INSERT INTO chat_messages (project_id, sender_id, sender_type, message) VALUES (?,?,?,?)");
        $stmt->execute([$projectId, $data['user_id'], $data['user_type'], $data['message']]);
        
        // Broadcast to project members
        foreach ($this->clients as $client) {
            if ($this->projects[$client->resourceId] == $projectId) {
                $client->send(json_encode([
                    'sender' => $data['sender_name'],
                    'message' => $data['message'],
                    'time' => date('H:i')
                ]));
            }
        }
    }
    
    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        unset($this->projects[$conn->resourceId]);
    }
    
    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }
}

// Run: php websocket/server.php