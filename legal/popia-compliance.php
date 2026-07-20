<?php
declare(strict_types=1);
require_once '../includes/functions.php';

$pageTitle = 'POPIA Compliance';
require_once '../includes/header.php';
?>

<section class="section" style="padding-top:140px;">
    <div class="container" style="max-width:800px;">
        <span class="section-tag">/ Legal</span>
        <h1 class="section-title">POPIA <span class="highlight">Compliance</span></h1>
        
        <div style="font-size:var(--font-size-base); line-height:1.8; color:var(--text-secondary);">
            <p style="margin-bottom:16px;"><strong>Effective date:</strong> May 27, 2026</p>
            
            <div style="background:var(--bg-secondary); padding:24px; border-radius:var(--border-radius-lg); margin:24px 0; border-left:4px solid var(--color-accent);">
                <p style="margin:0;"><strong>Information Officer:</strong> Njabulo Dlamini</p>
                <p style="margin:8px 0 0;"><strong>Contact:</strong> <a href="mailto:<?= getSetting('contact_email', 'njabulod.hlongwane@gmail.com') ?>" style="color:var(--color-accent);"><?= getSetting('contact_email', 'njabulod.hlongwane@gmail.com') ?></a></p>
            </div>
            
            <h2 style="font-size:var(--font-size-xl); font-weight:700; color:var(--text-primary); margin:32px 0 16px;">1. About POPIA</h2>
            <p>The <strong>Protection of Personal Information Act (Act 4 of 2013)</strong> ("POPIA") is South Africa's data protection law. It regulates how organizations collect, process, store, and share personal information.</p>
            <p>Vueports Solutions is fully committed to complying with POPIA in all our data processing activities.</p>
            
            <h2 style="font-size:var(--font-size-xl); font-weight:700; color:var(--text-primary); margin:32px 0 16px;">2. Lawful Processing</h2>
            <p>We process personal information only when one of the following lawful bases applies:</p>
            <ul style="margin:16px 0; padding-left:24px;">
                <li><strong>Consent</strong> — You have given clear consent (e.g., newsletter signup, contact forms)</li>
                <li><strong>Contract</strong> — Processing is necessary for a contract (e.g., project engagement)</li>
                <li><strong>Legal obligation</strong> — We are required by law (e.g., tax records)</li>
                <li><strong>Legitimate interest</strong> — For our legitimate business interests (e.g., analytics, security)</li>
            </ul>
            
            <h2 style="font-size:var(--font-size-xl); font-weight:700; color:var(--text-primary); margin:32px 0 16px;">3. Information We Process</h2>
            <table style="width:100%; margin:16px 0; font-size:var(--font-size-sm);">
                <thead>
                    <tr style="border-bottom:2px solid var(--border-color);">
                        <th style="text-align:left; padding:12px;">Category</th>
                        <th style="text-align:left; padding:12px;">Purpose</th>
                        <th style="text-align:left; padding:12px;">Retention</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom:1px solid var(--border-color);">
                        <td style="padding:12px;">Contact details</td>
                        <td style="padding:12px;">Communication, project delivery</td>
                        <td style="padding:12px;">7 years</td>
                    </tr>
                    <tr style="border-bottom:1px solid var(--border-color);">
                        <td style="padding:12px;">Project data</td>
                        <td style="padding:12px;">Service delivery, support</td>
                        <td style="padding:12px;">7 years</td>
                    </tr>
                    <tr style="border-bottom:1px solid var(--border-color);">
                        <td style="padding:12px;">Payment records</td>
                        <td style="padding:12px;">Accounting, tax compliance</td>
                        <td style="padding:12px;">7 years</td>
                    </tr>
                    <tr style="border-bottom:1px solid var(--border-color);">
                        <td style="padding:12px;">Website analytics</td>
                        <td style="padding:12px;">Improve user experience</td>
                        <td style="padding:12px;">26 months</td>
                    </tr>
                    <tr>
                        <td style="padding:12px;">Email communications</td>
                        <td style="padding:12px;">Customer service, legal</td>
                        <td style="padding:12px;">7 years</td>
                    </tr>
                </tbody>
            </table>
            
            <h2 style="font-size:var(--font-size-xl); font-weight:700; color:var(--text-primary); margin:32px 0 16px;">4. Your Rights Under POPIA</h2>
            <p>As a data subject, you have the following rights:</p>
            
            <h3 style="font-size:var(--font-size-lg); font-weight:600; color:var(--text-primary); margin:24px 0 12px;">4.1 Right to Access</h3>
            <p>You may request a copy of all personal information we hold about you. We will respond within 30 days.</p>
            
            <h3 style="font-size:var(--font-size-lg); font-weight:600; color:var(--text-primary); margin:24px 0 12px;">4.2 Right to Correction</h3>
            <p>You may request that we correct any inaccurate or incomplete information.</p>
            
            <h3 style="font-size:var(--font-size-lg); font-weight:600; color:var(--text-primary); margin:24px 0 12px;">4.3 Right to Deletion</h3>
            <p>You may request deletion of your personal data, subject to legal retention requirements.</p>
            
            <h3 style="font-size:var(--font-size-lg); font-weight:600; color:var(--text-primary); margin:24px 0 12px;">4.4 Right to Object</h3>
            <p>You may object to processing for direct marketing or legitimate interests.</p>
            
            <h3 style="font-size:var(--font-size-lg); font-weight:600; color:var(--text-primary); margin:24px 0 12px;">4.5 Right to Lodge a Complaint</h3>
            <p>You may complain to the <strong>Information Regulator</strong>:</p>
            <p style="margin:12px 0;">
                Website: <a href="https://inforegulator.org.za" target="_blank" style="color:var(--color-accent);">inforegulator.org.za</a><br>
                Email: <a href="mailto:inforeg@justice.gov.za" style="color:var(--color-accent);">inforeg@justice.gov.za</a>
            </p>
            
            <h2 style="font-size:var(--font-size-xl); font-weight:700; color:var(--text-primary); margin:32px 0 16px;">5. Data Security Measures</h2>
            <p>We implement the following security measures:</p>
            <ul style="margin:16px 0; padding-left:24px;">
                <li>SSL/TLS encryption for all data transmission</li>
                <li>Password hashing using bcrypt</li>
                <li>Role-based access control</li>
                <li>Regular security audits and penetration testing</li>
                <li>Automated backup and disaster recovery</li>
                <li>Employee confidentiality agreements</li>
            </ul>
            
            <h2 style="font-size:var(--font-size-xl); font-weight:700; color:var(--text-primary); margin:32px 0 16px;">6. Data Breaches</h2>
            <p>In the event of a data breach, we will:</p>
            <ul style="margin:16px 0; padding-left:24px;">
                <li>Notify the Information Regulator within 72 hours</li>
                <li>Notify affected data subjects without undue delay</li>
                <li>Take immediate steps to contain and remediate the breach</li>
            </ul>
            
            <h2 style="font-size:var(--font-size-xl); font-weight:700; color:var(--text-primary); margin:32px 0 16px;">7. Cross-Border Transfers</h2>
            <p>We primarily process data in South Africa. If data is transferred outside the country, we ensure the recipient country has adequate data protection laws or implement appropriate safeguards.</p>
            
            <h2 style="font-size:var(--font-size-xl); font-weight:700; color:var(--text-primary); margin:32px 0 16px;">8. Contact Our Information Officer</h2>
            <p>For POPIA-related inquiries, data subject requests, or complaints:</p>
            <p style="margin:16px 0;">
                <strong>Njabulo Dlamini</strong><br>
                Information Officer<br>
                Vueports Solutions (Pty) Ltd<br>
                Email: <a href="mailto:<?= getSetting('contact_email', 'njabulod.hlongwane@gmail.com') ?>" style="color:var(--color-accent);"><?= getSetting('contact_email', 'njabulod.hlongwane@gmail.com') ?></a><br>
                Phone: <?= getSetting('contact_phone', '+27 (68) 826-1507') ?>
            </p>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>