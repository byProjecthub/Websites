<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/env.php';

function getRedis(): ?Redis {
    static $redis = null;
    
    if ($redis === null) {
        try {
            $redis = new Redis();
            $redis->connect(env('REDIS_HOST', '127.0.0.1'), (int)env('REDIS_PORT', '6379'));
            $redis->select(0);
        } catch (Exception $e) {
            error_log("Redis connection failed: " . $e->getMessage());
            return null;
        }
    }
    
    return $redis;
}

function cacheGet(string $key) {
    $redis = getRedis();
    if (!$redis) return null;
    
    $data = $redis->get('vueports:' . $key);
    return $data ? json_decode($data, true) : null;
}

function cacheSet(string $key, $data, int $ttl = 3600): bool {
    $redis = getRedis();
    if (!$redis) return false;
    
    return $redis->setex('vueports:' . $key, $ttl, json_encode($data));
}

function cacheForget(string $pattern): void {
    $redis = getRedis();
    if (!$redis) return;
    
    foreach ($redis->keys('vueports:' . $pattern) as $key) {
        $redis->del($key);
    }
}

function cacheRemember(string $key, callable $callback, int $ttl = 3600) {
    $cached = cacheGet($key);
    if ($cached !== null) return $cached;
    
    $value = $callback();
    cacheSet($key, $value, $ttl);
    return $value;
}