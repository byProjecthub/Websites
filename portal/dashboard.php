<?php
$pageTitle = 'Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | Vueports Portal</title>
  <link rel="stylesheet" href="../assets/css/variables.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="portal-layout">
  <!-- Sidebar -->
  <aside class="portal-sidebar">
    <div class="portal-sidebar-logo">Vueports<span>.</span></div>

    <nav class="portal-nav">
      <a href="dashboard.php" class="active">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
        Dashboard
      </a>
      <a href="#">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
        Projects
      </a>
      <a href="#">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
        Invoices
      </a>
      <a href="#">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
        Messages
      </a>
      <a href="#">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
        Settings
      </a>
    </nav>

    <div style="margin-top: auto; padding-top: var(--space-6); border-top: 1px solid var(--border-subtle);">
      <a href="../index.php" style="display: flex; align-items: center; gap: var(--space-3); padding: var(--space-3) var(--space-4); border-radius: var(--radius-lg); font-size: var(--text-sm); font-weight: 500; color: var(--text-secondary); transition: all var(--transition-fast);">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
        Sign Out
      </a>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="portal-main">
    <div class="portal-header">
      <h1>Dashboard</h1>
      <div style="display: flex; align-items: center; gap: var(--space-4);">
        <div style="width: 40px; height: 40px; border-radius: var(--radius-full); background: var(--accent-indigo-bg); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: var(--text-sm); color: var(--accent-indigo);">JD</div>
        <div>
          <div style="font-size: var(--text-sm); font-weight: 600;">John Doe</div>
          <div style="font-size: var(--text-xs); color: var(--text-muted);">TechCorp Ltd</div>
        </div>
      </div>
    </div>

    <!-- Stats -->
    <div class="portal-stats">
      <div class="portal-stat-card">
        <div class="stat-label">Active Projects</div>
        <div class="stat-value">3</div>
      </div>
      <div class="portal-stat-card">
        <div class="stat-label">Completed</div>
        <div class="stat-value">12</div>
      </div>
      <div class="portal-stat-card">
        <div class="stat-label">Open Invoices</div>
        <div class="stat-value">2</div>
      </div>
      <div class="portal-stat-card">
        <div class="stat-label">Total Spent</div>
        <div class="stat-value">$45K</div>
      </div>
    </div>

    <!-- Projects Table -->
    <div style="margin-bottom: var(--space-8);">
      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-6);">
        <h2 style="font-size: var(--text-xl); font-weight: 700;">Recent Projects</h2>
        <a href="#" class="btn-arrow">View All <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
      </div>

      <div class="portal-table">
        <table>
          <thead>
            <tr>
              <th>Project</th>
              <th>Type</th>
              <th>Status</th>
              <th>Progress</th>
              <th>Due Date</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="font-weight: 600; color: var(--text-primary);">E-Commerce Platform</td>
              <td>Web App</td>
              <td><span class="status-badge active">Active</span></td>
              <td>
                <div style="width: 100px; height: 6px; background: var(--border-subtle); border-radius: var(--radius-full); overflow: hidden;">
                  <div style="width: 75%; height: 100%; background: var(--accent-emerald); border-radius: var(--radius-full);"></div>
                </div>
              </td>
              <td>Aug 30, 2026</td>
            </tr>
            <tr>
              <td style="font-weight: 600; color: var(--text-primary);">Data Pipeline</td>
              <td>Data Engineering</td>
              <td><span class="status-badge pending">In Progress</span></td>
              <td>
                <div style="width: 100px; height: 6px; background: var(--border-subtle); border-radius: var(--radius-full); overflow: hidden;">
                  <div style="width: 45%; height: 100%; background: var(--accent-amber); border-radius: var(--radius-full);"></div>
                </div>
              </td>
              <td>Sep 15, 2026</td>
            </tr>
            <tr>
              <td style="font-weight: 600; color: var(--text-primary);">AI Support Bot</td>
              <td>AI Agent</td>
              <td><span class="status-badge completed">Completed</span></td>
              <td>
                <div style="width: 100px; height: 6px; background: var(--border-subtle); border-radius: var(--radius-full); overflow: hidden;">
                  <div style="width: 100%; height: 100%; background: var(--accent-blue); border-radius: var(--radius-full);"></div>
                </div>
              </td>
              <td>Jul 20, 2026</td>
            </tr>
            <tr>
              <td style="font-weight: 600; color: var(--text-primary);">Mobile Banking App</td>
              <td>Mobile</td>
              <td><span class="status-badge active">Active</span></td>
              <td>
                <div style="width: 100px; height: 6px; background: var(--border-subtle); border-radius: var(--radius-full); overflow: hidden;">
                  <div style="width: 30%; height: 100%; background: var(--accent-emerald); border-radius: var(--radius-full);"></div>
                </div>
              </td>
              <td>Oct 10, 2026</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Recent Invoices -->
    <div>
      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-6);">
        <h2 style="font-size: var(--text-xl); font-weight: 700;">Recent Invoices</h2>
        <a href="#" class="btn-arrow">View All <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
      </div>

      <div class="portal-table">
        <table>
          <thead>
            <tr>
              <th>Invoice #</th>
              <th>Project</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="font-weight: 600; color: var(--text-primary);">#INV-2026-084</td>
              <td>E-Commerce Platform</td>
              <td style="font-weight: 600; color: var(--text-primary);">$3,500</td>
              <td><span class="status-badge pending">Pending</span></td>
              <td>Aug 1, 2026</td>
            </tr>
            <tr>
              <td style="font-weight: 600; color: var(--text-primary);">#INV-2026-083</td>
              <td>Data Pipeline</td>
              <td style="font-weight: 600; color: var(--text-primary);">$2,800</td>
              <td><span class="status-badge active">Paid</span></td>
              <td>Jul 25, 2026</td>
            </tr>
            <tr>
              <td style="font-weight: 600; color: var(--text-primary);">#INV-2026-082</td>
              <td>AI Support Bot</td>
              <td style="font-weight: 600; color: var(--text-primary);">$5,000</td>
              <td><span class="status-badge active">Paid</span></td>
              <td>Jul 15, 2026</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</div>

</body>
</html>
