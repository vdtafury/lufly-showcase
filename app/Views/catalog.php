<?php
declare(strict_types=1);

use App\Config\App;
use App\Helpers\I18n;
use App\Helpers\Security;

/** @var array $breadcrumbs */
$loc = I18n::getLocale();
?>

<?php require __DIR__ . '/components/breadcrumbs.php'; ?>

<section style="padding: 2rem 0 5rem;">
    <div class="l-container">
        <div style="max-width: 780px; margin-bottom: 3.5rem;">
            <span class="section-eyebrow">
                <?= $loc === 'tr' ? 'Teknik Yayınlar &bull; 2025 Sürümü' : ($loc === 'cs' ? 'Technické publikace &bull; Vydání 2025' : 'Technical Publications &bull; 2025 Edition') ?>
            </span>
            <h1 class="display-title" style="font-size: clamp(2.2rem, 3.5vw, 3.25rem); margin-top: 0.35rem;">
                <?= I18n::t('catalog_page_title') ?>
            </h1>
            <p style="color: var(--c-muted); font-size: 1.0625rem; margin-top: 1rem; line-height: 1.65;">
                <?= I18n::t('catalog_page_desc') ?>
            </p>
        </div>

        <!-- 3 Catalog Volumes -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem; margin-bottom: 4rem;">
            <!-- Volume 1 -->
            <div style="background-color: var(--c-white); border: 1px solid var(--c-divider); border-radius: var(--radius-md); padding: 2rem; display: flex; flex-direction: column;">
                <div style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-eucalyptus); margin-bottom: 0.5rem; font-weight: 600;">VOLUME 01 &bull; 148 <?= $loc === 'tr' ? 'SAYFA' : ($loc === 'cs' ? 'STRAN' : 'PAGES') ?></div>
                <h3 style="font-size: 1.35rem; color: var(--c-obsidian); margin-bottom: 0.75rem;">
                    <?= $loc === 'tr' ? 'Ana Vitrifiye Seramik Kataloğu' : ($loc === 'cs' ? 'Hlavní katalog sanitární keramiky' : 'Master Vitreous Ceramics Lookbook') ?>
                </h3>
                <p style="color: var(--c-muted); font-size: 0.875rem; line-height: 1.6; margin-bottom: 1.5rem; flex-grow: 1;">
                    <?= $loc === 'tr' ? 'Kanalsız asma klozetler, tasarım çanak lavabolar, seramik bideler ve banyo mobilyaları kapsamlı ürün portföyü.' : ($loc === 'cs' ? 'Kompletní portfolio závěsných WC mís Rimless, designových umyvadel na desku, bidetů a koupelnového nábytku.' : 'Comprehensive portfolio of rimless wall-hung WC suites, designer vessel washbasins, ceramic bidets, and vanity furniture configurations.') ?>
                </p>
                <div style="border-top: 1px solid var(--c-divider-subtle); padding-top: 1.25rem; display: flex; justify-content: space-between; align-items: center;">
                    <a href="<?= locale_url('/contact?type=catalog&product=Volume_01_Master_Lookbook') ?>" class="btn btn-primary" style="padding: 0.55rem 1rem; font-size: 0.8125rem;">
                        <span><?= $loc === 'tr' ? 'Dijital Kopyayı İste' : ($loc === 'cs' ? 'Vyžádat digitální kopii' : 'Request Digital Copy') ?></span>
                    </a>
                    <span style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-muted);">PDF &bull; 48 MB</span>
                </div>
            </div>

            <!-- Volume 2 -->
            <div style="background-color: var(--c-white); border: 1px solid var(--c-divider); border-radius: var(--radius-md); padding: 2rem; display: flex; flex-direction: column;">
                <div style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-eucalyptus); margin-bottom: 0.5rem; font-weight: 600;">VOLUME 02 &bull; 92 <?= $loc === 'tr' ? 'SAYFA' : ($loc === 'cs' ? 'STRAN' : 'PAGES') ?></div>
                <h3 style="font-size: 1.35rem; color: var(--c-obsidian); margin-bottom: 0.75rem;">
                    <?= $loc === 'tr' ? 'Mimari Bataryalar & Duş Sistemleri' : ($loc === 'cs' ? 'Vodovodní baterie a sprchové systémy' : 'Architectural Tapware & Showers') ?>
                </h3>
                <p style="color: var(--c-muted); font-size: 0.875rem; line-height: 1.6; margin-bottom: 1.5rem; flex-grow: 1;">
                    <?= $loc === 'tr' ? 'Masif pirinç lavabo armatürleri, ankastre termostatik duş kolonları ve mutfak bataryaları teknik çizimleri ve debi tabloları.' : ($loc === 'cs' ? 'Mosazné umyvadlové baterie, podomítkové termostatické sprchové systémy a dřezové armatury včetně technických výkresů.' : 'Solid brass basin mixers, concealed thermostatic shower systems, and kitchen fixtures. Technical exploded diagrams and flow-rate charts.') ?>
                </p>
                <div style="border-top: 1px solid var(--c-divider-subtle); padding-top: 1.25rem; display: flex; justify-content: space-between; align-items: center;">
                    <a href="<?= locale_url('/contact?type=catalog&product=Volume_02_Tapware') ?>" class="btn btn-primary" style="padding: 0.55rem 1rem; font-size: 0.8125rem;">
                        <span><?= $loc === 'tr' ? 'Dijital Kopyayı İste' : ($loc === 'cs' ? 'Vyžádat digitální kopii' : 'Request Digital Copy') ?></span>
                    </a>
                    <span style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-muted);">PDF &bull; 32 MB</span>
                </div>
            </div>

            <!-- Volume 3: Raw Data Export -->
            <div style="background-color: var(--c-white); border: 1px solid var(--c-forest); border-radius: var(--radius-md); padding: 2rem; display: flex; flex-direction: column;">
                <div style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-champagne); margin-bottom: 0.5rem; font-weight: 600;">DATA INTEGRATION &bull; REST API</div>
                <h3 style="font-size: 1.35rem; color: var(--c-obsidian); margin-bottom: 0.75rem;">
                    <?= $loc === 'tr' ? 'Eksiksiz Teknik JSON Veri Tabanı' : ($loc === 'cs' ? 'Kompletní technická data v JSON' : 'Complete Technical Dataset (JSON)') ?>
                </h3>
                <p style="color: var(--c-muted); font-size: 0.875rem; line-height: 1.6; margin-bottom: 1.5rem; flex-grow: 1;">
                    <?= $loc === 'tr' ? 'Tüm 282 onaylı modelin resmi fabrika kodları, boyutları, malzeme kompozisyonları ve Avrupa normları yapılandırılmış JSON formatında.' : ($loc === 'cs' ? 'Export všech 282 certifikovaných modelů s oficiálními kódy SKU, rozměry a normami v přehledném formátu JSON.' : 'Export all 282 verified products with official factory SKUs, dimensions, material compositions, and European compliance standards in structured JSON format.') ?>
                </p>
                <div style="border-top: 1px solid var(--c-divider-subtle); padding-top: 1.25rem; display: flex; justify-content: space-between; align-items: center;">
                    <a href="/catalog/export-json" class="btn btn-champagne" style="padding: 0.55rem 1rem; font-size: 0.8125rem;" download>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span><?= $loc === 'tr' ? 'Veri Tabanını İndir' : ($loc === 'cs' ? 'Stáhnout data' : 'Download Dataset') ?></span>
                    </a>
                    <span style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-forest);">LIVE &bull; 282 SKUs</span>
                </div>
            </div>
        </div>

        <!-- Request Showroom Binder Form Banner -->
        <div style="background: linear-gradient(135deg, var(--c-forest) 0%, var(--c-obsidian) 100%); border-radius: var(--radius-md); padding: 3.5rem 3rem; color: var(--c-white); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 2rem;">
            <div style="max-width: 580px;">
                <span style="font-family: var(--font-mono); font-size: 0.75rem; letter-spacing: 0.15em; text-transform: uppercase; color: var(--c-champagne);"><?= $loc === 'tr' ? 'Ciltli Showroom Özel Sürümü' : ($loc === 'cs' ? 'Pevná vazba pro showroom' : 'Hardcover Showroom Edition') ?></span>
                <h2 style="font-family: var(--font-serif); font-size: 2rem; color: var(--c-white); margin-top: 0.5rem;"><?= I18n::t('request_printed') ?></h2>
                <p style="color: #9fb5ab; font-size: 0.9375rem; margin-top: 0.5rem; line-height: 1.6;">
                    <?= $loc === 'tr' ? 'Avrupa ve İngiltere genelindeki yetkili mimarlık ofisleri, vitrifiye showroomları ve ticari proje geliştiricilerine doğrudan gönderilir. Orijinal seramik sır numunelerini içerir.' : ($loc === 'cs' ? 'Dodáváno přímo architektonickým ateliérům, koupelnovým studiím a developerům po celé Evropě. Obsahuje reálné vzorky keramické glazury.' : 'Supplied directly to verified architectural practices, sanitary showrooms, and commercial developers across Europe and the United Kingdom. Includes authentic ceramic glaze swatch tiles.') ?>
                </p>
            </div>
            <a href="<?= locale_url('/contact?type=printed_binder') ?>" class="btn btn-champagne" style="padding: 0.9rem 1.75rem;">
                <span><?= $loc === 'tr' ? 'Showroom Kataloğu Talep Et &rarr;' : ($loc === 'cs' ? 'Objednat vzorník &rarr;' : 'Order Showroom Binder &rarr;') ?></span>
            </a>
        </div>
    </div>
</section>
