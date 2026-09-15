<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Config\App;

class I18n
{
    private static string $locale = 'tr'; // Default Turkish

    public const SUPPORTED_LOCALES = ['tr', 'en', 'cs'];

    public const LOCALE_NAMES = [
        'tr' => 'TR',
        'en' => 'EN',
        'cs' => 'CS'
    ];

    public const LOCALE_FULL_NAMES = [
        'tr' => 'Türkçe',
        'en' => 'English',
        'cs' => 'Čeština'
    ];

    public const OG_LOCALES = [
        'tr' => 'tr_TR',
        'en' => 'en_GB',
        'cs' => 'cs_CZ'
    ];

    private static array $dictionary = [
        // Topbar
        'topbar_cert' => [
            'tr' => 'EN 997 & CE Sertifikalı Vitreous China',
            'en' => 'EN 997 & CE Certified Vitreous China',
            'cs' => 'Certifikace EN 997 & CE Sanitární keramika'
        ],
        'topbar_guarantee' => [
            'tr' => '10 Yıl Fabrika Garantisi',
            'en' => '10-Year Factory Guarantee',
            'cs' => '10 let tovární záruka'
        ],
        'topbar_export' => [
            'tr' => '34+ Ülkeye İhracat',
            'en' => 'Exporting to 34+ Countries',
            'cs' => 'Export do více než 34 zemí'
        ],
        'topbar_whatsapp' => [
            'tr' => 'WhatsApp B2B Masası',
            'en' => 'WhatsApp B2B Desk',
            'cs' => 'WhatsApp B2B podpora'
        ],
        'whatsapp_greeting' => [
            'tr' => 'Merhaba Lufly İhracat Departmanı, fabrika konteyner tedariği hakkında bilgi almak istiyorum.',
            'en' => 'Hello Lufly Export Department, I am inquiring regarding factory container procurement.',
            'cs' => 'Dobrý den, exportní oddělení Lufly, rád bych poptal tovární dodávky a odběr sanitární keramiky.'
        ],

        // Header & Nav
        'brand_subhead' => [
            'tr' => 'Mimari Seramikler',
            'en' => 'Architectural Ceramics',
            'cs' => 'Architektonická keramika'
        ],
        'brand_origin' => [
            'tr' => 'Gaziantep Fabrikası • EN 997',
            'en' => 'Gaziantep Factory • EN 997',
            'cs' => 'Továrna Gaziantep • EN 997'
        ],
        'nav_home' => [
            'tr' => 'Ana Sayfa',
            'en' => 'Home',
            'cs' => 'Domů'
        ],
        'nav_collections' => [
            'tr' => 'Koleksiyonlar',
            'en' => 'Collections',
            'cs' => 'Kolekce'
        ],
        'nav_all_products' => [
            'tr' => 'Tüm Ürünler (282)',
            'en' => 'All Products (282)',
            'cs' => 'Všechny produkty (282)'
        ],
        'nav_lookbook' => [
            'tr' => 'Dijital Katalog',
            'en' => 'Digital Lookbook',
            'cs' => 'Digitální katalog'
        ],
        'nav_procurement' => [
            'tr' => 'Fabrika Tedariği',
            'en' => 'Factory Procurement',
            'cs' => 'Tovární nákup'
        ],
        'search_placeholder' => [
            'tr' => 'Katalogda model veya SKU ara (örn. 1620, Lavabo, Batarya)...',
            'en' => 'Search 282 certified models by SKU code or name (e.g. 1620, Washbasin, Mixer)...',
            'cs' => 'Hledat 282 certifikovaných modelů podle kódu nebo názvu (např. 1620, Umyvadlo)...'
        ],
        'search_trigger' => [
            'tr' => 'Katalogda ara...',
            'en' => 'Search catalog...',
            'cs' => 'Hledat v katalogu...'
        ],
        'request_b2b_quote' => [
            'tr' => 'B2B Teklif İste',
            'en' => 'Request B2B Quote',
            'cs' => 'Poptat B2B nabídku'
        ],
        'open_mobile_menu' => [
            'tr' => 'Mobil Menüyü Aç',
            'en' => 'Open Mobile Menu',
            'cs' => 'Otevřít mobilní menu'
        ],

        // Footer
        'footer_tagline' => [
            'tr' => 'Lüks konut projeleri, ticari yapılar ve Avrupa ihracat dağıtımı için Gaziantep\'te üretilen yüksek hassasiyetli mimari vitrifiye seramikleri.',
            'en' => 'Precision architectural sanitary ceramics engineered in Gaziantep, Turkey for luxury residential developments, commercial hospitality, and European export distribution.',
            'cs' => 'Vysoce přesná architektonická sanitární keramika vyráběná v Gaziantepu pro luxusní rezidenční projekty, komerční objekty a evropský export.'
        ],
        'footer_collections_title' => [
            'tr' => 'Koleksiyonlar',
            'en' => 'Collections',
            'cs' => 'Kolekce'
        ],
        'footer_view_all_collections' => [
            'tr' => 'Tüm Koleksiyonları İncele →',
            'en' => 'View All Collections →',
            'cs' => 'Zobrazit všechny kolekce →'
        ],
        'footer_documentation_title' => [
            'tr' => 'Teknik Dökümantasyon',
            'en' => 'Documentation',
            'cs' => 'Dokumentace'
        ],
        'footer_lookbook_link' => [
            'tr' => '2025 Ana Katalog & Lookbook',
            'en' => '2025 Master Lookbook',
            'cs' => 'Hlavní katalog 2025'
        ],
        'footer_json_datafeed' => [
            'tr' => 'Teknik JSON Veri Akışı',
            'en' => 'Technical JSON Datafeed',
            'cs' => 'Technický datový export JSON'
        ],
        'footer_b2b_inquiries' => [
            'tr' => 'B2B Konteyner Siparişleri',
            'en' => 'B2B Container Inquiries',
            'cs' => 'Poptávka kontejnerových zásilek'
        ],
        'footer_oem_specs' => [
            'tr' => 'OEM Fabrika Şartnameleri',
            'en' => 'OEM Factory Specifications',
            'cs' => 'OEM tovární specifikace'
        ],
        'footer_sitemap' => [
            'tr' => 'XML Ürün Haritası',
            'en' => 'XML Product Sitemap',
            'cs' => 'XML mapa stránek'
        ],
        'footer_standards_title' => [
            'tr' => 'Üretim Standartları',
            'en' => 'Manufacturing Standards',
            'cs' => 'Výrobní standardy'
        ],
        'footer_all_rights_reserved' => [
            'tr' => 'Tüm hakları saklıdır.',
            'en' => 'All rights reserved.',
            'cs' => 'Všechna práva vyhrazena.'
        ],
        'footer_standards_sub' => [
            'tr' => 'Mimari Vitrifiye Seramikleri • Avrupa Standartlarında Üretim • İhracat Sürümü',
            'en' => 'Architectural Sanitary Ceramics • Designed to European Standards • Export Edition',
            'cs' => 'Architektonická sanitární keramika • Vyrobeno podle evropských norem • Exportní vydání'
        ],
        'search_guidance' => [
            'tr' => 'Aramak için ürün kodu (örn. 1620-111) veya model adı giriniz.',
            'en' => 'Type a product code (e.g. 1620-111) or category name to search.',
            'cs' => 'Zadejte kód produktu (např. 1620-111) nebo název pro vyhledávání.'
        ],
        'search_results_for' => [
            'tr' => 'Arama Sonuçları:',
            'en' => 'Search Results for:',
            'cs' => 'Výsledky vyhledávání pro:'
        ],
        'no_results_found' => [
            'tr' => 'Aramanızla eşleşen ürün bulunamadı.',
            'en' => 'No products found matching your search term.',
            'cs' => 'Nebyly nalezeny žádné produkty odpovídající vašemu dotazu.'
        ],
        'models_found' => [
            'tr' => 'model bulundu',
            'en' => 'models found',
            'cs' => 'nalezených modelů'
        ],

        // Home Page
        'hero_badge' => [
            'tr' => 'Avrupa Standartlarında Üretim Vitrifiye Seramikleri',
            'en' => 'Architectural Sanitary Ceramics • Gaziantep Factory',
            'cs' => 'Architektonická sanitární keramika • Továrna Gaziantep'
        ],
        'hero_title' => [
            'tr' => 'Avrupa Yaşamı İçin Tasarlanan Mimari Vitrifiye Seramikleri.',
            'en' => 'Architectural Sanitary Ceramics Engineered for European Living.',
            'cs' => 'Architektonická sanitární keramika navržená pro evropský standard bydlení.'
        ],
        'hero_description' => [
            'tr' => 'Gaziantep entegre tesislerimizde EN 997 standartlarında %100 yüksek kalite vitreous china\'dan üretilen kanalsız asma klozetler, tasarım lavabolar ve lüks armatürler.',
            'en' => 'Precision-engineered rimless wall-hung toilets, designer countertop washbasins, and architectural tapware. Fired at 1,250°C for exceptional durability and European project specification.',
            'cs' => 'Precizní závěsné WC mísy bez oplachového kruhu, designová umyvadla na desku a architektonické baterie. Vypalováno při 1 250 °C pro výjimečnou odolnost.'
        ],
        'hero_cta_explore' => [
            'tr' => 'Koleksiyonları Keşfedin',
            'en' => 'Explore Collections',
            'cs' => 'Prozkoumat kolekce'
        ],
        'hero_cta_lookbook' => [
            'tr' => '2025 Kataloğunu İndirin',
            'en' => 'Download 2025 Lookbook',
            'cs' => 'Stáhnout katalog 2025'
        ],
        'section_engineering_title' => [
            'tr' => 'Mühendislik & Kalite Değerleri',
            'en' => 'Engineering & Vitreous Precision',
            'cs' => 'Technologie a keramická preciznost'
        ],
        'section_engineering_desc' => [
            'tr' => 'Avrupa normlarına uygun ileri üretim teknikleri ve sıfır tavizli seramik dayanıklılığı.',
            'en' => 'Advanced production technologies strictly conforming to European EN sanitary standards.',
            'cs' => 'Pokročilé výrobní technologie plně odpovídající evropským sanitárním normám EN.'
        ],
        'eng_1_title' => [
            'tr' => '1.250°C Vitreous Fırınlama',
            'en' => '1,250°C Vitreous Firing',
            'cs' => 'Vypalování při 1 250 °C'
        ],
        'eng_1_desc' => [
            'tr' => '%0.5\'in altında sıfıra yakın su emme oranı ve ömür boyu yapısal bütünlük sağlayan yüksek yoğunluklu fırınlama teknolojisi.',
            'en' => 'Dense molecular vitrification achieving <0.5% water absorption for unmatched frost, crack, and load durability.',
            'cs' => 'Vysoká hustota střepu s nasákavostí < 0,5 % zaručuje mimořádnou odolnost proti mrazu a mechanickému zatížení.'
        ],
        'eng_2_title' => [
            'tr' => 'Kanalsız (Rimless) Hidrodinamik',
            'en' => 'Rimless Hydrodynamics',
            'cs' => 'Hydrodynamika Rimless'
        ],
        'eng_2_desc' => [
            'tr' => 'Kanal içi bakteri birikimini sıfırlayan ve yıkama başına %40 su tasarrufu sağlayan aerodinamik akış dinamiği.',
            'en' => 'Concealed water distribution channels eliminate hidden bacteriological rims while conserving up to 40% flush water.',
            'cs' => 'Hladký vnitřní povrch bez oplachového kruhu eliminuje usazování nečistot a bakterií a šetří až 40 % vody.'
        ],
        'eng_3_title' => [
            'tr' => 'Nano-Shield Antibakteriyel Sır',
            'en' => 'Nano-Shield Glaze',
            'cs' => 'Glazura Nano-Shield'
        ],
        'eng_3_desc' => [
            'tr' => 'Seramik gözeneklerini mühürleyen, kireç tutmayan ve temizlik kimyasalı ihtiyacını azaltan ultra pürüzsüz yüzey.',
            'en' => 'Permanent silver-ion antibacterial ceramic glazing provides a mirror-smooth surface resistant to lime and chemicals.',
            'cs' => 'Trvalá antibakteriální glazura s ionty stříbra zajišťuje hladký povrch odolný proti vodnímu kameni a chemii.'
        ],
        'section_collections_title' => [
            'tr' => 'Öne Çıkan Mimari Koleksiyonlar',
            'en' => 'Curated Architectural Collections',
            'cs' => 'Vybrané architektonické kolekce'
        ],
        'section_collections_desc' => [
            'tr' => 'Lüks rezidanslar, otel projeleri ve ticari banyolar için tasarlanan bütünsel seramik serileri.',
            'en' => 'Holistic ceramic collections engineered for large-scale European architectural procurement.',
            'cs' => 'Ucelené keramické kolekce navržené pro evropské architektonické projekty a hotely.'
        ],
        'section_featured_title' => [
            'tr' => 'İmza Ürünler',
            'en' => 'Signature Certified Models',
            'cs' => 'Charakteristické certifikované modely'
        ],
        'section_featured_desc' => [
            'tr' => 'Uluslararası şartnamelerle uyumlu, fabrikadan doğrudan sevkiyata hazır modeller.',
            'en' => 'Direct factory production items fully compliant with CE and European EN standards.',
            'cs' => 'Přímo z výrobní linky, plně v souladu s evropskými normami CE a EN.'
        ],
        'section_heritage_title' => [
            'tr' => 'Gaziantep\'ten Avrupa\'ya: Üretim Mirasımız',
            'en' => 'Industrial Heritage & Factory Authority',
            'cs' => 'Průmyslová tradice a výrobní zázemí'
        ],
        'heritage_desc' => [
            'tr' => '2012 yılından bu yana Gaziantep Organize Sanayi Bölgesi\'ndeki tesislerimizde, en son Avrupa robotik sır ve fırınlama teknolojilerini Türk seramik ustalığı ile birleştiriyoruz. 34\'ten fazla ülkeye doğrudan fabrika ihracatı gerçekleştiriyoruz.',
            'en' => 'Since 2012, Lufly has operated advanced kiln manufacturing in Gaziantep, Turkey, fusing robotic glazing accuracy with Anatolian ceramic heritage. Today, we supply prestigious European architectural projects across 34+ export nations.',
            'cs' => 'Od roku 2012 vyrábí Lufly v Gaziantepu sanitární keramiku s využitím moderních robotických technologií a tradice tureckého keramického průmyslu. Dnes dodáváme do více než 34 zemí světa.'
        ],
        'heritage_stat_1_val' => ['tr' => '2012', 'en' => '2012', 'cs' => '2012'],
        'heritage_stat_1_lbl' => [
            'tr' => 'Kuruluş Yılı',
            'en' => 'Established in Gaziantep',
            'cs' => 'Založeno v Gaziantepu'
        ],
        'heritage_stat_2_val' => ['tr' => '34+', 'en' => '34+', 'cs' => '34+'],
        'heritage_stat_2_lbl' => [
            'tr' => 'İhracat Yapılan Ülke',
            'en' => 'Export Destination Countries',
            'cs' => 'Exportních zemí'
        ],
        'heritage_stat_3_val' => ['tr' => '280+', 'en' => '280+', 'cs' => '280+'],
        'heritage_stat_3_lbl' => [
            'tr' => 'Üretilen Vitrifiye Modeli',
            'en' => 'Certified Sanitary Models',
            'cs' => 'Certifikovaných modelů'
        ],
        'heritage_stat_4_val' => ['tr' => '10 Yıl', 'en' => '10 Years', 'cs' => '10 let'],
        'heritage_stat_4_lbl' => [
            'tr' => 'Seramik Gövde Garantisi',
            'en' => 'Vitreous Factory Warranty',
            'cs' => 'Záruka na keramiku'
        ],
        'section_quote_title' => [
            'tr' => 'Fabrika B2B Teklif Masası',
            'en' => 'Direct Factory Procurement & B2B Inquiry',
            'cs' => 'Přímá poptávka továrních dodávek a B2B poptávka'
        ],
        'section_quote_desc' => [
            'tr' => 'Konteyner bazlı alımlar, toptan dağıtım ve proje şartnameleri için fabrika satış departmanımızla doğrudan iletişime geçin.',
            'en' => 'Submit specifications for container loads, contract wholesale distribution, or private label manufacturing.',
            'cs' => 'Odešlete poptávku na kontejnerové zásilky, velkoobchodní distribuci nebo zakázkovou výrobu.'
        ],
        'form_company' => [
            'tr' => 'Şirket / Kuruluş Adı',
            'en' => 'Company / Enterprise Name',
            'cs' => 'Název společnosti / firmy'
        ],
        'form_name' => [
            'tr' => 'Yetkili Adı Soyadı',
            'en' => 'Contact Officer Name',
            'cs' => 'Jméno kontaktní osoby'
        ],
        'form_email' => [
            'tr' => 'Kurumsal E-posta',
            'en' => 'Corporate Email Address',
            'cs' => 'Firemní e-mail'
        ],
        'form_phone' => [
            'tr' => 'Telefon / WhatsApp',
            'en' => 'Direct Telephone / WhatsApp',
            'cs' => 'Telefon / WhatsApp'
        ],
        'form_country' => [
            'tr' => 'Ülke / Sevkiyat Limanı',
            'en' => 'Country / Destination Port',
            'cs' => 'Země / Cílový přístav'
        ],
        'form_type' => [
            'tr' => 'Tedarik Kapsamı',
            'en' => 'Procurement Scope',
            'cs' => 'Rozsah poptávky'
        ],
        'form_type_container' => [
            'tr' => 'Tam Konteyner Yükü (FCL İhracat)',
            'en' => 'Full Container Load (FCL Export)',
            'cs' => 'Celokontejnerová zásilka (FCL)'
        ],
        'form_type_project' => [
            'tr' => 'Toplu Proje / Otel Şartnamesi',
            'en' => 'Hospitality / Contract Project Spec',
            'cs' => 'Hotelový / developerský projekt'
        ],
        'form_type_oem' => [
            'tr' => 'OEM / Özel Marka Üretimi',
            'en' => 'OEM Private Label Manufacturing',
            'cs' => 'Výroba pod vlastní značkou (OEM)'
        ],
        'form_message' => [
            'tr' => 'Teknik Şartname & Talep Detayları',
            'en' => 'Technical Specifications & Requirements',
            'cs' => 'Technická specifikace a požadavky'
        ],
        'form_submit' => [
            'tr' => 'Fabrika Teklifi Talep Et',
            'en' => 'Submit Procurement Inquiry',
            'cs' => 'Odeslat poptávku továrně'
        ],

        // Products & Category Pages
        'filter_all' => [
            'tr' => 'Tüm Modeller',
            'en' => 'All Models',
            'cs' => 'Všechny modely'
        ],
        'sort_default' => [
            'tr' => 'Varsayılan Sıralama',
            'en' => 'Default Sort',
            'cs' => 'Výchozí řazení'
        ],
        'sort_price_asc' => [
            'tr' => 'Fiyat: Düşükten Yükseğe',
            'en' => 'Price: Low to High',
            'cs' => 'Cena: Od nejnižší'
        ],
        'sort_price_desc' => [
            'tr' => 'Fiyat: Yüksekten Düşüğe',
            'en' => 'Price: High to Low',
            'cs' => 'Cena: Od nejvyšší'
        ],
        'sort_sku_asc' => [
            'tr' => 'Ürün Kodu: A-Z',
            'en' => 'SKU Code: A to Z',
            'cs' => 'Kód SKU: A-Z'
        ],
        'sort_name_asc' => [
            'tr' => 'Model Adı: A-Z',
            'en' => 'Model Name: A to Z',
            'cs' => 'Název: A-Z'
        ],
        'view_specs' => [
            'tr' => 'Teknik Özellikler',
            'en' => 'View Specifications',
            'cs' => 'Zobrazit specifikaci'
        ],
        'instock' => [
            'tr' => 'Fabrika Stoğunda Mevcut',
            'en' => 'In Stock / Ready for Dispatch',
            'cs' => 'Skladem v továrně'
        ],
        'onbackorder' => [
            'tr' => 'Üretime Alınabilir / Özel Sipariş',
            'en' => 'Available on Factory Order',
            'cs' => 'K dispozici na objednávku'
        ],
        'specs_dimensions' => [
            'tr' => 'Boyutlar',
            'en' => 'Dimensions',
            'cs' => 'Rozměry'
        ],
        'specs_material' => [
            'tr' => 'Malzeme',
            'en' => 'Material',
            'cs' => 'Materiál'
        ],
        'specs_mounting' => [
            'tr' => 'Montaj Tipi',
            'en' => 'Mounting Type',
            'cs' => 'Způsob montáže'
        ],
        'specs_finish' => [
            'tr' => 'Sır Kaplama',
            'en' => 'Glaze & Finish',
            'cs' => 'Glazura a povrch'
        ],
        'specs_warranty' => [
            'tr' => 'Fabrika Garantisi',
            'en' => 'Factory Warranty',
            'cs' => 'Záruka výrobce'
        ],
        'specs_standards' => [
            'tr' => 'Standart & Sertifikalar',
            'en' => 'Certifications & Standards',
            'cs' => 'Certifikace a normy'
        ],
        'cta_quote' => [
            'tr' => 'WhatsApp ile Fabrika Teklifi İste',
            'en' => 'Request Factory Quote via WhatsApp',
            'cs' => 'Poptat nabídku přes WhatsApp'
        ],
        'cta_download_pdf' => [
            'tr' => 'Teknik CAD / Çizim İndir',
            'en' => 'Download Technical CAD / Specs',
            'cs' => 'Stáhnout technický výkres / CAD'
        ],
        'tab_specs' => [
            'tr' => 'Teknik Şartname',
            'en' => 'Technical Specifications',
            'cs' => 'Technická specifikace'
        ],
        'tab_cad' => [
            'tr' => 'Mimari Çizim & Montaj',
            'en' => 'Architectural CAD & Installation',
            'cs' => 'Architektonické výkresy a montáž'
        ],
        'tab_packaging' => [
            'tr' => 'Paketleme & Palet Standartları',
            'en' => 'Packaging & Palletization',
            'cs' => 'Balení a paletizace'
        ],
        'related_products_title' => [
            'tr' => 'Tamamlayıcı & İlgili Modeller',
            'en' => 'Related Architectural Models',
            'cs' => 'Související architektonické modely'
        ],
        'showing_products' => [
            'tr' => 'Gösterilen modeller:',
            'en' => 'Showing models:',
            'cs' => 'Zobrazené modely:'
        ],

        // Catalog Page
        'catalog_page_title' => [
            'tr' => '2025 Dijital Mimari Kataloglar & Şartnameler',
            'en' => '2025 Architectural Master Lookbooks & Spec Sheets',
            'cs' => 'Digitální architektonické katalogy a specifikace 2025'
        ],
        'catalog_page_desc' => [
            'tr' => 'Avrupa şartnamelerine uygun vitrifiye seramik ürünlerimizin dijital kataloglarını ve teknik veri setlerini indirin.',
            'en' => 'Download official factory catalogs and technical specifications for commercial and residential procurement.',
            'cs' => 'Stáhněte si oficiální tovární katalogy a technické specifikace pro rezidenční a komerční projekty.'
        ],
        'download_catalog' => [
            'tr' => 'Kataloğu İndir (PDF)',
            'en' => 'Download Lookbook (PDF)',
            'cs' => 'Stáhnout katalog (PDF)'
        ],
        'download_json' => [
            'tr' => 'Teknik JSON Veri Tabanını İndir (282 Model)',
            'en' => 'Download Technical Specification Dataset (JSON)',
            'cs' => 'Stáhnout technická data v JSON (282 modelů)'
        ],
        'request_printed' => [
            'tr' => 'Basılı Showroom Kataloğu Talep Et',
            'en' => 'Request Printed Showroom Binder (Hardcover)',
            'cs' => 'Objednat tištěný vzorník pro showroom'
        ],

        // Contact Page
        'contact_page_title' => [
            'tr' => 'Fabrika İletişim & B2B İhracat Masası',
            'en' => 'Factory Headquarters & European B2B Desk',
            'cs' => 'Sídlo továrny a evropská B2B podpora'
        ],
        'contact_page_desc' => [
            'tr' => 'Doğrudan üreticiden konteyner bazlı alım, OEM üretim ve uluslararası proje şartnameleri için bizimle iletişime geçin.',
            'en' => 'Direct factory contact for full-container export, OEM manufacturing, and European project specifications.',
            'cs' => 'Přímý kontakt s výrobcem pro kontejnerové dodávky, OEM výrobu a evropské projekty.'
        ],
        'headquarters' => [
            'tr' => 'Fabrika ve Genel Merkez',
            'en' => 'Factory & Corporate Headquarters',
            'cs' => 'Výrobní závod a sídlo společnosti'
        ],
        'export_desk' => [
            'tr' => 'İhracat Departmanı',
            'en' => 'International Export Desk',
            'cs' => 'Oddělení mezinárodního exportu'
        ],
        'working_hours' => [
            'tr' => 'Çalışma Saatleri',
            'en' => 'Working Hours',
            'cs' => 'Pracovní doba'
        ],
        'working_hours_val' => [
            'tr' => 'Pazartesi – Cuma: 08:30 – 18:00 (TSİ)',
            'en' => 'Monday – Friday: 08:30 – 18:00 (GMT+3)',
            'cs' => 'Pondělí – Pátek: 08:30 – 18:00 (GMT+3)'
        ],

        // 404
        'page_not_found_title' => [
            'tr' => '404 - Sayfa Bulunamadı',
            'en' => '404 - Page Not Found',
            'cs' => '404 - Stránka nenalezena'
        ],
        'page_not_found_desc' => [
            'tr' => 'Aradığınız sayfa taşınmış veya silinmiş olabilir.',
            'en' => 'The requested page could not be located in the catalog.',
            'cs' => 'Požadovaná stránka nebyla v katalogu nalezena.'
        ],
        'back_to_home' => [
            'tr' => 'Ana Sayfaya Dön',
            'en' => 'Return to Homepage',
            'cs' => 'Zpět na domovskou stránku'
        ]
    ];

    public static function setLocale(string $locale): void
    {
        $locale = strtolower(trim($locale));
        if (in_array($locale, self::SUPPORTED_LOCALES, true)) {
            self::$locale = $locale;
        } else {
            self::$locale = 'tr'; // Default Turkish
        }
    }

    public static function getLocale(): string
    {
        return self::$locale;
    }

    public static function t(string $key, array $replace = []): string
    {
        $lang = self::$locale;
        $text = self::$dictionary[$key][$lang] ?? self::$dictionary[$key]['tr'] ?? self::$dictionary[$key]['en'] ?? $key;

        foreach ($replace as $placeholder => $value) {
            $text = str_replace(':' . $placeholder, (string)$value, $text);
        }

        return $text;
    }

    /**
     * Build locale-aware URL
     * Default 'tr' is at root (/path)
     * 'en' is at /en/path
     * 'cs' is at /cs/path
     */
    public static function url(string $path = '', ?string $locale = null): string
    {
        $loc = $locale ?? self::$locale;
        $cleanPath = '/' . ltrim($path, '/');

        // Strip any existing locale prefix from cleanPath
        foreach (self::SUPPORTED_LOCALES as $l) {
            if ($cleanPath === "/{$l}" || str_starts_with($cleanPath, "/{$l}/")) {
                $cleanPath = substr($cleanPath, strlen($l) + 1);
                $cleanPath = '/' . ltrim($cleanPath, '/');
                break;
            }
        }

        if ($cleanPath === '//') $cleanPath = '/';

        if ($loc === 'tr') {
            return $cleanPath === '/' ? '/' : $cleanPath;
        }

        return $cleanPath === '/' ? "/{$loc}" : "/{$loc}{$cleanPath}";
    }

    /**
     * Get alternate URLs for all 3 locales for hreflang links and the language switcher
     */
    public static function getAlternateUrls(string $currentPath): array
    {
        $cleanPath = '/' . ltrim($currentPath, '/');
        foreach (self::SUPPORTED_LOCALES as $l) {
            if ($cleanPath === "/{$l}" || str_starts_with($cleanPath, "/{$l}/")) {
                $cleanPath = substr($cleanPath, strlen($l) + 1);
                $cleanPath = '/' . ltrim($cleanPath, '/');
                break;
            }
        }
        if ($cleanPath === '//') $cleanPath = '/';

        return [
            'tr' => self::url($cleanPath, 'tr'),
            'en' => self::url($cleanPath, 'en'),
            'cs' => self::url($cleanPath, 'cs'),
        ];
    }
}

require_once __DIR__ . '/functions.php';
