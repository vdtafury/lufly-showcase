<?php
declare(strict_types=1);

use App\Config\App;
use App\Helpers\Security;

/** @var string $prefillSku */
/** @var string $prefillProduct */
/** @var array $breadcrumbs */
/** @var ?string $status */
?>

<?php require __DIR__ . '/components/breadcrumbs.php'; ?>

<section style="padding: 2rem 0 5rem;">
    <div class="l-container">
        <!-- Status Banners -->
        <?php if ($status === 'success'): ?>
            <div style="background-color: #edf7ed; color: #1e4620; border: 1px solid #c8e6c9; border-radius: var(--radius-sm); padding: 1.25rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                <div>
                    <strong>Inquiry Logged Successfully.</strong> Our European export department has received your inquiry and will respond with formal container pricing within 24 hours.
                </div>
            </div>
        <?php elseif ($status === 'validation_error'): ?>
            <div style="background-color: #fde8e8; color: #9b1c1c; border: 1px solid #f8b4b4; border-radius: var(--radius-sm); padding: 1.25rem; margin-bottom: 2rem;">
                Please ensure all required fields (Name, Corporate Email, Message) are completed.
            </div>
        <?php elseif ($status === 'csrf_error'): ?>
            <div style="background-color: #fde8e8; color: #9b1c1c; border: 1px solid #f8b4b4; border-radius: var(--radius-sm); padding: 1.25rem; margin-bottom: 2rem;">
                Security validation token expired. Please refresh the page and submit again.
            </div>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 4rem; align-items: flex-start;">
            <!-- Left: Factory Quotation Form -->
            <div>
                <span class="section-eyebrow">B2B Procurement &bull; Container Export</span>
                <h1 class="display-title" style="font-size: clamp(2rem, 3.5vw, 3rem); margin-top: 0.35rem; margin-bottom: 1rem;">
                    Direct Factory Inquiry
                </h1>
                <p style="color: var(--c-muted); font-size: 1rem; line-height: 1.6; margin-bottom: 2rem;">
                    Submit formal requests for container quotes (FCL/LCL), project specification pricing, OEM manufacturing inquiries, or technical CAD packages.
                </p>

                <form method="POST" action="/contact/submit" style="background-color: var(--c-white); border: 1px solid var(--c-divider); border-radius: var(--radius-md); padding: 2.25rem;">
                    <?= Security::csrfField() ?>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                        <div class="form-group">
                            <label class="form-label" for="company-name">Company / Practice Name</label>
                            <input type="text" id="company-name" name="company_name" class="form-control" placeholder="e.g. Studio Vitra Architekten" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="contact-name">Contact Person *</label>
                            <input type="text" id="contact-name" name="contact_name" class="form-control" placeholder="e.g. Thomas Müller" required>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                        <div class="form-group">
                            <label class="form-label" for="email">Corporate Email Address *</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="t.mueller@architects.de" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="phone">Direct Phone / Mobile</label>
                            <input type="tel" id="phone" name="phone" class="form-control" placeholder="+49 30 1234567">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                        <div class="form-group">
                            <label class="form-label" for="country">Country of Project / Port</label>
                            <input type="text" id="country" name="country" class="form-control" placeholder="e.g. Germany, UK, Netherlands">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="inquiry-type">Inquiry Classification</label>
                            <select id="inquiry-type" name="inquiry_type" class="form-control">
                                <option value="quote">Container Export Quotation (FCL)</option>
                                <option value="distributor">National Distributor Partnership</option>
                                <option value="architectural_project">Architectural Tender Specification</option>
                                <option value="sample">Physical Glaze Sample Request</option>
                                <option value="catalog">Printed Master Binder Order</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="product-sku">Target Model SKU / Name (Optional)</label>
                        <input type="text" 
                               id="product-sku" 
                               name="product_sku" 
                               value="<?= Security::e($prefillSku ? ($prefillSku . ($prefillProduct ? " - {$prefillProduct}" : '')) : '') ?>" 
                               class="form-control" 
                               placeholder="e.g. 1620-111 Rimless Wall-Hung WC">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="message">Project Requirements / Estimated Quantities *</label>
                        <textarea id="message" name="message" class="form-control" placeholder="Please describe your project timeline, required unit quantities, discharge port, or technical questions..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 0.9375rem;">
                        <span>Transmit Factory Inquiry &rarr;</span>
                    </button>
                </form>
            </div>

            <!-- Right: Corporate & Factory Identity -->
            <div>
                <div style="background-color: var(--c-white); border: 1px solid var(--c-divider); border-radius: var(--radius-md); padding: 2rem; margin-bottom: 2rem;">
                    <span style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-eucalyptus); font-weight: 600; text-transform: uppercase;">Factory Headquarters</span>
                    <h3 style="font-size: 1.25rem; color: var(--c-obsidian); margin: 0.5rem 0 1rem;">Gaziantep Industrial Facility</h3>
                    
                    <div style="font-size: 0.875rem; color: #43554e; line-height: 1.7; display: flex; flex-direction: column; gap: 0.85rem;">
                        <div>
                            <strong style="color: var(--c-obsidian);"><?= App::FULL_LEGAL_NAME ?></strong><br>
                            <?= App::ADDRESS ?>
                        </div>
                        <div style="border-top: 1px solid var(--c-divider-subtle); padding-top: 0.85rem;">
                            <strong>Telephone Desk:</strong><br>
                            <a href="tel:<?= App::PHONE_CLEAN ?>" style="color: var(--c-forest); font-weight: 600;"><?= App::PHONE ?></a>
                        </div>
                        <div>
                            <strong>Export Sales Department:</strong><br>
                            <a href="mailto:<?= App::SALES_EMAIL ?>" style="color: var(--c-forest);"><?= App::SALES_EMAIL ?></a>
                        </div>
                        <div>
                            <strong>Corporate Administration:</strong><br>
                            <a href="mailto:<?= App::EMAIL ?>" style="color: var(--c-forest);"><?= App::EMAIL ?></a>
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--c-divider);">
                        <a href="https://wa.me/<?= App::WHATSAPP ?>?text=<?= urlencode('Hello Lufly Export Department, I am inquiring regarding factory container procurement.') ?>" 
                           target="_blank" 
                           rel="noopener" 
                           class="btn btn-secondary" 
                           style="width: 100%; border-color: #25D366; color: #128C7E;">
                            <span>Direct WhatsApp B2B Liaison</span>
                        </a>
                    </div>
                </div>

                <!-- Export Specifications -->
                <div style="background-color: var(--c-sage-light); border: 1px solid var(--c-sage); border-radius: var(--radius-md); padding: 1.75rem;">
                    <h4 style="font-size: 1rem; color: var(--c-forest); margin-bottom: 0.75rem; font-weight: 600;">International Logistics</h4>
                    <ul style="font-size: 0.8125rem; color: #374d42; line-height: 1.6; list-style-position: inside; display: flex; flex-direction: column; gap: 0.5rem;">
                        <li><strong>Incoterms:</strong> FOB Mersin Port, CIF European Destination, EXW Gaziantep.</li>
                        <li><strong>Standard Lead Time:</strong> 3–4 weeks for 40ft High Cube container loads.</li>
                        <li><strong>Packaging:</strong> 5-ply reinforced export cartons with thermoformed drop-tested EPS foam.</li>
                        <li><strong>Quality Assurance:</strong> 100% individual vacuum &amp; hydraulic leak testing before palletization.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
