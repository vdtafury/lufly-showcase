<?php
declare(strict_types=1);

use App\Config\App;
use App\Helpers\I18n;
use App\Helpers\Security;

/** @var string $prefillSku */
/** @var string $prefillProduct */
/** @var array $breadcrumbs */
/** @var ?string $status */

$loc = I18n::getLocale();
?>

<?php require __DIR__ . '/components/breadcrumbs.php'; ?>

<section style="padding: 2rem 0 5rem;">
    <div class="l-container">
        <!-- Status Banners -->
        <?php if ($status === 'success'): ?>
            <div style="background-color: #edf7ed; color: #1e4620; border: 1px solid #c8e6c9; border-radius: var(--radius-sm); padding: 1.25rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                <div>
                    <strong><?= $loc === 'tr' ? 'Talebiniz Başarıyla Kaydedildi.' : ($loc === 'cs' ? 'Poptávka byla úspěšně odeslána.' : 'Inquiry Logged Successfully.') ?></strong> 
                    <?= $loc === 'tr' ? 'Fabrika ihracat departmanımız talebinizi almış olup en geç 24 saat içinde resmi konteyner teklifimiz iletilecektir.' : ($loc === 'cs' ? 'Naše exportní oddělení obdrželo vaši poptávku a do 24 hodin vám zašle oficiální cenovou nabídku.' : 'Our European export department has received your inquiry and will respond with formal container pricing within 24 hours.') ?>
                </div>
            </div>
        <?php elseif ($status === 'validation_error'): ?>
            <div style="background-color: #fde8e8; color: #9b1c1c; border: 1px solid #f8b4b4; border-radius: var(--radius-sm); padding: 1.25rem; margin-bottom: 2rem;">
                <?= $loc === 'tr' ? 'Lütfen tüm zorunlu alanları (Yetkili Adı, E-posta, Mesaj) doldurunuz.' : ($loc === 'cs' ? 'Vyplňte prosím všechna povinná pole (Jméno, E-mail, Zpráva).' : 'Please ensure all required fields (Name, Corporate Email, Message) are completed.') ?>
            </div>
        <?php elseif ($status === 'csrf_error'): ?>
            <div style="background-color: #fde8e8; color: #9b1c1c; border: 1px solid #f8b4b4; border-radius: var(--radius-sm); padding: 1.25rem; margin-bottom: 2rem;">
                <?= $loc === 'tr' ? 'Güvenlik doğrulama oturumu zaman aşımına uğradı. Sayfayı yenileyip tekrar deneyiniz.' : ($loc === 'cs' ? 'Platnost bezpečnostního tokenu vypršela. Obnovte prosím stránku a odešlete formulář znovu.' : 'Security validation token expired. Please refresh the page and submit again.') ?>
            </div>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 4rem; align-items: flex-start;">
            <!-- Left: Factory Quotation Form -->
            <div>
                <span class="section-eyebrow"><?= $loc === 'tr' ? 'B2B Tedarik &bull; Konteyner İhracatı' : ($loc === 'cs' ? 'B2B nákup &bull; Kontejnerový export' : 'B2B Procurement &bull; Container Export') ?></span>
                <h1 class="display-title" style="font-size: clamp(2rem, 3.5vw, 3rem); margin-top: 0.35rem; margin-bottom: 1rem;">
                    <?= I18n::t('contact_page_title') ?>
                </h1>
                <p style="color: var(--c-muted); font-size: 1rem; line-height: 1.6; margin-bottom: 2rem;">
                    <?= I18n::t('contact_page_desc') ?>
                </p>

                <form method="POST" action="/contact/submit" style="background-color: var(--c-white); border: 1px solid var(--c-divider); border-radius: var(--radius-md); padding: 2.25rem;">
                    <?= Security::csrfField() ?>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                        <div class="form-group">
                            <label class="form-label" for="company-name"><?= I18n::t('form_company') ?></label>
                            <input type="text" id="company-name" name="company_name" class="form-control" placeholder="<?= $loc === 'tr' ? 'Örn. Doğan Mimarlık A.Ş.' : ($loc === 'cs' ? 'např. Studio Vitra Architekti' : 'e.g. Studio Vitra Architects') ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="contact-name"><?= I18n::t('form_name') ?> *</label>
                            <input type="text" id="contact-name" name="contact_name" class="form-control" placeholder="<?= $loc === 'tr' ? 'Örn. Mehmet Yılmaz' : ($loc === 'cs' ? 'např. Jan Novák' : 'e.g. Thomas Müller') ?>" required>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                        <div class="form-group">
                            <label class="form-label" for="email"><?= I18n::t('form_email') ?> *</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="info@company.com" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="phone"><?= I18n::t('form_phone') ?></label>
                            <input type="tel" id="phone" name="phone" class="form-control" placeholder="+90 532 000 0000">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                        <div class="form-group">
                            <label class="form-label" for="country"><?= I18n::t('form_country') ?></label>
                            <input type="text" id="country" name="country" class="form-control" placeholder="<?= $loc === 'tr' ? 'Örn. Almanya, İngiltere, Çekya' : ($loc === 'cs' ? 'např. Česko, Německo, Slovensko' : 'e.g. Germany, UK, Czech Republic') ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="inquiry-type"><?= I18n::t('form_type') ?></label>
                            <select id="inquiry-type" name="inquiry_type" class="form-control">
                                <option value="quote"><?= I18n::t('form_type_container') ?></option>
                                <option value="distributor"><?= $loc === 'tr' ? 'Bölge Distribütörlüğü & Toptan Alım' : ($loc === 'cs' ? 'Distribuční a velkoobchodní partnerství' : 'National Distributor Partnership') ?></option>
                                <option value="architectural_project"><?= I18n::t('form_type_project') ?></option>
                                <option value="oem"><?= I18n::t('form_type_oem') ?></option>
                                <option value="catalog"><?= I18n::t('request_printed') ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="product-sku"><?= $loc === 'tr' ? 'İlgilenilen Model / SKU Kodu' : ($loc === 'cs' ? 'Kód SKU / Název modelu' : 'Target Model SKU / Name') ?></label>
                        <input type="text" 
                               id="product-sku" 
                               name="product_sku" 
                               value="<?= Security::e($prefillSku ? ($prefillSku . ($prefillProduct ? " - {$prefillProduct}" : '')) : '') ?>" 
                               class="form-control" 
                               placeholder="e.g. 1620-111 Rimless Wall-Hung WC">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="message"><?= I18n::t('form_message') ?> *</label>
                        <textarea id="message" name="message" class="form-control" placeholder="<?= $loc === 'tr' ? 'Lütfen proje takviminizi, tahmini adetleri, teslimat limanını veya teknik sorularınızı belirtiniz...' : ($loc === 'cs' ? 'Uveďte prosím časový harmonogram projektu, požadované množství, cílový přístav nebo technické dotazy...' : 'Please describe your project timeline, required unit quantities, discharge port, or technical questions...') ?>" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 0.9375rem;">
                        <span><?= I18n::t('form_submit') ?> &rarr;</span>
                    </button>
                </form>
            </div>

            <!-- Right: Corporate & Factory Identity -->
            <div>
                <div style="background-color: var(--c-white); border: 1px solid var(--c-divider); border-radius: var(--radius-md); padding: 2rem; margin-bottom: 2rem;">
                    <span style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-eucalyptus); font-weight: 600; text-transform: uppercase;"><?= I18n::t('headquarters') ?></span>
                    <h3 style="font-size: 1.25rem; color: var(--c-obsidian); margin: 0.5rem 0 1rem;"><?= $loc === 'tr' ? 'Gaziantep Entegre Üretim Tesisleri' : ($loc === 'cs' ? 'Výrobní závod Gaziantep' : 'Gaziantep Industrial Facility') ?></h3>
                    
                    <div style="font-size: 0.875rem; color: #43554e; line-height: 1.7; display: flex; flex-direction: column; gap: 0.85rem;">
                        <div>
                            <strong style="color: var(--c-obsidian);"><?= App::FULL_LEGAL_NAME ?></strong><br>
                            <?= App::ADDRESS ?>
                        </div>
                        <div style="border-top: 1px solid var(--c-divider-subtle); padding-top: 0.85rem;">
                            <strong><?= $loc === 'tr' ? 'Santral Telefon:' : ($loc === 'cs' ? 'Telefonní linka:' : 'Telephone Desk:') ?></strong><br>
                            <a href="tel:<?= App::PHONE_CLEAN ?>" style="color: var(--c-forest); font-weight: 600;"><?= App::PHONE ?></a>
                        </div>
                        <div>
                            <strong><?= I18n::t('export_desk') ?>:</strong><br>
                            <a href="mailto:<?= App::SALES_EMAIL ?>" style="color: var(--c-forest);"><?= App::SALES_EMAIL ?></a>
                        </div>
                        <div>
                            <strong><?= $loc === 'tr' ? 'Şirket Yönetimi:' : ($loc === 'cs' ? 'Vedení společnosti:' : 'Corporate Administration:') ?></strong><br>
                            <a href="mailto:<?= App::EMAIL ?>" style="color: var(--c-forest);"><?= App::EMAIL ?></a>
                        </div>
                        <div style="border-top: 1px solid var(--c-divider-subtle); padding-top: 0.85rem;">
                            <strong><?= I18n::t('working_hours') ?>:</strong><br>
                            <span><?= I18n::t('working_hours_val') ?></span>
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--c-divider);">
                        <a href="https://wa.me/<?= App::WHATSAPP ?>?text=<?= urlencode(I18n::t('whatsapp_greeting')) ?>" 
                           target="_blank" 
                           rel="noopener" 
                           class="btn btn-secondary" 
                           style="width: 100%; border-color: #25D366; color: #128C7E;">
                            <span><?= I18n::t('topbar_whatsapp') ?></span>
                        </a>
                    </div>
                </div>

                <!-- Export Specifications -->
                <div style="background-color: var(--c-sage-light); border: 1px solid var(--c-sage); border-radius: var(--radius-md); padding: 1.75rem;">
                    <h4 style="font-size: 1rem; color: var(--c-forest); margin-bottom: 0.75rem; font-weight: 600;"><?= $loc === 'tr' ? 'Uluslararası Lojistik Standartları' : ($loc === 'cs' ? 'Mezinárodní logistika' : 'International Logistics') ?></h4>
                    <ul style="font-size: 0.8125rem; color: #374d42; line-height: 1.6; list-style-position: inside; display: flex; flex-direction: column; gap: 0.5rem;">
                        <li><strong>Incoterms:</strong> <?= $loc === 'tr' ? 'FOB Mersin Limanı, CIF Avrupa Limanları, EXW Gaziantep Fabrika.' : ($loc === 'cs' ? 'FOB přístav Mersin, CIF evropské přístavy, EXW Gaziantep.' : 'FOB Mersin Port, CIF European Destination, EXW Gaziantep.') ?></li>
                        <li><strong><?= $loc === 'tr' ? 'Teslim Süresi:' : ($loc === 'cs' ? 'Dodací lhůta:' : 'Standard Lead Time:') ?></strong> <?= $loc === 'tr' ? '40ft High Cube konteynerler için 3–4 hafta.' : ($loc === 'cs' ? '3–4 týdny pro kontejnerové zásilky 40ft High Cube.' : '3–4 weeks for 40ft High Cube container loads.') ?></li>
                        <li><strong><?= $loc === 'tr' ? 'Paketleme:' : ($loc === 'cs' ? 'Balení:' : 'Packaging:') ?></strong> <?= $loc === 'tr' ? '5 katlı güçlendirilmiş ihracat kolileri ve termoform EPS strafor koruma.' : ($loc === 'cs' ? '5vrstvý zesílený exportní karton s tvarovanou EPS pěnou.' : '5-ply reinforced export cartons with thermoformed drop-tested EPS foam.') ?></li>
                        <li><strong><?= $loc === 'tr' ? 'Kalite Kontrol:' : ($loc === 'cs' ? 'Kontrola kvality:' : 'Quality Assurance:') ?></strong> <?= $loc === 'tr' ? 'Paletleme öncesi %100 bireysel vakum ve hidrolik sızdırmazlık testi.' : ($loc === 'cs' ? '100% individuální vakuové a tlakové zkoušky před paletizací.' : '100% individual vacuum & hydraulic leak testing before palletization.') ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
