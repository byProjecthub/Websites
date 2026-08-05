# ============================================
# calculator.php — ROOT LEVEL (merged with functional calculator(1).php)
# ============================================
calculator_php = '''<?php
declare(strict_types=1);
require_once 'includes/functions.php';
require_once 'includes/emails.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'quote') {
    if (!verifyCsrf($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid token.';
    } else {
        $db = db();
        if ($db) {
            $stmt = $db->prepare("INSERT INTO calculator_leads 
                (service_type, complexity, features, estimated_total, name, email, phone, company, submitted, ip_address, created_at) 
                VALUES (?,?,?,?,?,?,?,?,?,?, NOW())");
            $stmt->execute([
                sanitize($_POST['service_type'] ?? ''),
                sanitize($_POST['complexity'] ?? ''),
                $_POST['features'] ?? '{}',
                (float) ($_POST['estimated_max'] ?? $_POST['estimated_min'] ?? 0),
                sanitize($_POST['name'] ?? ''),
                filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL),
                sanitize($_POST['phone'] ?? ''),
                sanitize($_POST['company'] ?? ''),
                1,
                $_SERVER['REMOTE_ADDR'] ?? ''
            ]);
        }
        sendCalculatorLead([
            'name' => sanitize($_POST['name'] ?? ''),
            'email' => filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL),
            'service_type' => sanitize($_POST['service_type'] ?? ''),
            'estimated_min' => (float) ($_POST['estimated_min'] ?? 0),
            'estimated_max' => (float) ($_POST['estimated_max'] ?? 0),
        ]);
        $success = 'Estimate sent to your email. We will follow up with a formal quote within 24 hours.';
    }
}

$pageTitle = 'Price Calculator';
require_once 'includes/header.php';
?>

<section class="page-header">
  <div class="page-header-bg">Calculate</div>
  <div class="container">
    <div class="page-header-content">
      <span class="section-label">Price Calculator</span>
      <h1 class="page-header-title">Estimate your<br>project cost.</h1>
      <p class="page-header-desc">Answer a few questions and get an instant ballpark estimate for your project.</p>
    </div>
  </div>
</section>

<section class="section" style="padding-top: 0;">
  <div class="container">
    <div class="calculator-card reveal">
      <?php if ($success): ?>
        <div class="alert alert-success" style="margin-bottom: var(--space-6);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="display:inline; vertical-align:text-bottom; margin-right:var(--space-2);"><polyline points="20 6 9 17 4 12"></polyline></svg>
          <?php echo htmlspecialchars($success); ?>
        </div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="alert alert-error" style="margin-bottom: var(--space-6);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="display:inline; vertical-align:text-bottom; margin-right:var(--space-2);"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>

      <!-- Service Tabs -->
      <div style="display: flex; gap: var(--space-3); margin-bottom: var(--space-8); flex-wrap: wrap;">
        <button type="button" class="btn btn-primary" id="tab-software" onclick="switchService('software')">Custom Software</button>
        <button type="button" class="btn btn-secondary" id="tab-data" onclick="switchService('data')">Data Engineering</button>
        <button type="button" class="btn btn-secondary" id="tab-ai" onclick="switchService('ai')">AI Agents</button>
      </div>

      <!-- Software Panel -->
      <div id="panel-software" class="calculator-section">
        <h3>Custom Software & Web Development</h3>
        <div class="calculator-options">
          <label class="calculator-option selected">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Landing / Marketing Site</span>
            </div>
            <span class="option-price">Base</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Web Application</span>
            </div>
            <span class="option-price">+40%</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">SaaS Platform</span>
            </div>
            <span class="option-price">+80%</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">E-commerce</span>
            </div>
            <span class="option-price">+60%</span>
          </label>
        </div>
      </div>

      <!-- Data Panel -->
      <div id="panel-data" class="calculator-section" style="display: none;">
        <h3>Data Engineering & Analytics</h3>
        <div class="calculator-options">
          <label class="calculator-option selected">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">1 – 2 Data Sources</span>
            </div>
            <span class="option-price">Base</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">3 – 5 Data Sources</span>
            </div>
            <span class="option-price">+50%</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">6 – 10 Data Sources</span>
            </div>
            <span class="option-price">+100%</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">10+ Sources / Enterprise</span>
            </div>
            <span class="option-price">Custom</span>
          </label>
        </div>
      </div>

      <!-- AI Panel -->
      <div id="panel-ai" class="calculator-section" style="display: none;">
        <h3>AI Agent Development</h3>
        <div class="calculator-options">
          <label class="calculator-option selected">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Simple Chatbot (Q&A)</span>
            </div>
            <span class="option-price">Base</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Workflow Assistant</span>
            </div>
            <span class="option-price">+40%</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Autonomous Agent</span>
            </div>
            <span class="option-price">+80%</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Multi-Agent System</span>
            </div>
            <span class="option-price">Custom</span>
          </label>
        </div>
      </div>

      <!-- Complexity -->
      <div class="calculator-section">
        <h3>What's the complexity level?</h3>
        <div class="calculator-options">
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Simple — Basic features, minimal integrations</span>
            </div>
            <span class="option-price">Base</span>
          </label>
          <label class="calculator-option selected">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Medium — Multiple features, some integrations</span>
            </div>
            <span class="option-price">+40%</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Complex — Advanced features, many integrations</span>
            </div>
            <span class="option-price">+80%</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Enterprise — Custom everything, high scale</span>
            </div>
            <span class="option-price">Custom</span>
          </label>
        </div>
      </div>

      <!-- Add-ons -->
      <div class="calculator-section">
        <h3>Any add-ons?</h3>
        <div class="calculator-options">
          <label class="calculator-option selected">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Admin Dashboard</span>
            </div>
            <span class="option-price">+R15,000</span>
          </label>
          <label class="calculator-option selected">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Payment Integration</span>
            </div>
            <span class="option-price">+R10,000</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Real-time Chat / Notifications</span>
            </div>
            <span class="option-price">+R20,000</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">AI Features (Chatbot, Recommendations)</span>
            </div>
            <span class="option-price">+R35,000</span>
          </label>
          <label class="calculator-option selected">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">3 Months Support</span>
            </div>
            <span class="option-price">+R15,000</span>
          </label>
        </div>
      </div>

      <!-- Total -->
      <div class="calculator-total">
        <div class="total-label">Estimated Total</div>
        <div class="total-value">R<span id="totalValue">12,500</span></div>
      </div>

      <div style="display: flex; gap: var(--space-4); margin-top: var(--space-8); flex-wrap: wrap;">
        <button type="button" onclick="showQuoteForm()" class="btn btn-primary btn-lg" style="flex: 1; min-width: 200px;">
          Get Formal Quote
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </button>
        <a href="consultation.php" class="btn btn-secondary btn-lg" style="flex: 1; min-width: 200px;">Book a Free Call</a>
      </div>

      <p style="font-size: var(--text-xs); color: var(--text-muted); text-align: center; margin-top: var(--space-6);">This is a ballpark estimate. Final pricing depends on detailed requirements. Book a call for an accurate quote.</p>

      <!-- Quote Form -->
      <div id="quoteForm" style="display: none; margin-top: var(--space-8); padding-top: var(--space-8); border-top: 1px solid var(--border-subtle);">
        <h3 style="font-size: var(--text-xl); font-weight: 700; margin-bottom: var(--space-6);">Get a Formal Quote</h3>
        <form method="POST" action="calculator.php">
          <input type="hidden" name="csrf_token" value="<?php echo csrfToken(); ?>">
          <input type="hidden" name="action" value="quote">
          <input type="hidden" name="service_type" id="quoteService" value="Custom Software & Web">
          <input type="hidden" name="complexity" id="quoteComplexity" value="medium">
          <input type="hidden" name="features" id="quoteFeatures" value="{}">
          <input type="hidden" name="estimated_min" id="quoteMin" value="10000">
          <input type="hidden" name="estimated_max" id="quoteMax" value="15000">

          <div class="grid-2" style="gap: var(--space-4);">
            <div class="form-group">
              <label class="form-label">Full Name *</label>
              <input type="text" name="name" required class="form-input" placeholder="John Doe">
            </div>
            <div class="form-group">
              <label class="form-label">Email *</label>
              <input type="email" name="email" required class="form-input" placeholder="john@company.com">
            </div>
          </div>

          <div class="grid-2" style="gap: var(--space-4);">
            <div class="form-group">
              <label class="form-label">Phone</label>
              <input type="tel" name="phone" class="form-input" placeholder="+27 68 826 1507">
            </div>
            <div class="form-group">
              <label class="form-label">Company</label>
              <input type="text" name="company" class="form-input" placeholder="Your company">
            </div>
          </div>

          <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
            Send Estimate to My Inbox
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<script>
let currentService = 'software';

function switchService(key) {
  currentService = key;
  document.querySelectorAll('[id^="panel-"]').forEach(p => p.style.display = 'none');
  document.getElementById('panel-' + key).style.display = 'block';
  document.querySelectorAll('[id^="tab-"]').forEach(t => {
    t.classList.remove('btn-primary');
    t.classList.add('btn-secondary');
  });
  document.getElementById('tab-' + key).classList.remove('btn-secondary');
  document.getElementById('tab-' + key).classList.add('btn-primary');
  document.getElementById('quoteService').value = key === 'software' ? 'Custom Software & Web' : key === 'data' ? 'Data Engineering' : 'AI Agent Development';
}

document.querySelectorAll('.calculator-option').forEach(option => {
  option.addEventListener('click', function() {
    const parent = this.closest('.calculator-section');
    const isMulti = parent.querySelectorAll('.calculator-option').length > 4;
    if (!isMulti) {
      parent.querySelectorAll('.calculator-option').forEach(o => o.classList.remove('selected'));
    }
    this.classList.toggle('selected');
  });
});

function showQuoteForm() {
  document.getElementById('quoteForm').style.display = 'block';
  document.getElementById('quoteForm').scrollIntoView({ behavior: 'smooth' });
}
</script>

<?php include 'includes/footer.php'; ?>
