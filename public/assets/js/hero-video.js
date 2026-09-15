/**
 * Lufly Architectural Ceramics - Cinematic Hero Video & Transition Controller
 * Handles multi-scene video playback, timeline progress bar, glassmorphism card transitions,
 * and fullscreen theater lightbox mode.
 */

(function () {
  'use strict';

  function initHeroVideo() {
    var hero = document.querySelector('.hero-cinematic');
    if (!hero) return;

    var currentLocale = window.LUFLY_LOCALE || document.documentElement.lang || 'tr';
    if (currentLocale.indexOf('tr') === 0) currentLocale = 'tr';
    else if (currentLocale.indexOf('cs') === 0) currentLocale = 'cs';
    else currentLocale = 'en';

    var scenes = [
      {
        id: 0,
        videoId: 'hero-video-1',
        tag: {
          tr: '01 • MİMARİ BANYO VİTRİFİYESİ',
          en: '01 • ARCHITECTURAL SANITARY SUITE',
          cs: '01 • ARCHITEKTONICKÝ SANITÁRNÍ SET'
        },
        title: {
          tr: 'Avrupa Yaşamı İçin Tasarlanan Mimari Vitrifiye Seramikleri.',
          en: 'Architectural Sanitary Ceramics Engineered for European Living.',
          cs: 'Architektonická sanitární keramika navržená pro evropský standard bydlení.'
        },
        desc: {
          tr: 'Gaziantep entegre tesislerimizde EN 997 standartlarında %100 yüksek kalite vitreous china\'dan üretilen kanalsız asma klozetler, tasarım lavabolar ve lüks armatürler.',
          en: 'Precision-engineered rimless wall-hung toilets, designer countertop washbasins, and architectural tapware. Fired at 1,250°C for exceptional durability and European project specification.',
          cs: 'Precizní závěsné WC mísy bez oplachového kruhu, designová umyvadla na desku a architektonické baterie. Vypalováno při 1 250 °C pro výjimečnou odolnost.'
        },
        model: {
          badge: 'FLAGSHIP • EN 997',
          sku: '1620-111',
          name: {
            tr: 'Kanalsız Asma Klozet',
            en: 'Rimless Wall-Hung WC Pan',
            cs: 'Závěsná WC mísa Rimless'
          },
          specs: {
            tr: '540 × 360 mm • Gizli Duvar Montajı',
            en: '540 × 360 mm • Concealed Wall-Hung',
            cs: '540 × 360 mm • Skrytá montáž na stěnu'
          },
          img: '/assets/images/products/lufly_146_1620-111-a.jpg',
          url: '/products/rimless-wall-hung-wc-pan-ewo-sdh-128-146'
        }
      },
      {
        id: 1,
        videoId: 'hero-video-2',
        tag: {
          tr: '02 • 1.250°C VİTREOUS FIRINLAMA',
          en: '02 • 1,250°C KILN PRECISION',
          cs: '02 • PÁLENÍ PŘI 1 250 °C'
        },
        title: {
          tr: '1.250°C Yüksek Yoğunluklu Vitreous China Dayanıklılığı.',
          en: '1,250°C High-Density Vitreous China Resilience.',
          cs: 'Vysoká odolnost sanitární keramiky Vitreous China pálené při 1 250 °C.'
        },
        desc: {
          tr: 'Mikron düzeyinde sır homojenliği, %0.5\'in altında sıfıra yakın su emme oranı ve ömür boyu çatlamazlık garantisi sunan robotik fırınlama.',
          en: 'Sub-micron glaze uniformity, ultra-low <0.5% water absorption rate, and lifetime structural integrity achieved through robotic kiln firing.',
          cs: 'Mikronová homogenita glazury, téměř nulová nasákavost < 0,5 % a celoživotní strukturální celistvost dosažená robotickým výpalem.'
        },
        model: {
          badge: 'MASTERPIECE • CE',
          sku: '1610-554',
          name: {
            tr: 'DUERO Çanak Lavabo',
            en: 'DUERO Countertop Washbasin',
            cs: 'DUERO Umyvadlo na desku'
          },
          specs: {
            tr: '600 × 420 × 140 mm • İnce Kenar',
            en: '600 × 420 × 140 mm • Ultra-Slim Rim',
            cs: '600 × 420 × 140 mm • Tenkostěnný lem'
          },
          img: '/assets/images/products/lufly_205_ESINO.jpg',
          url: '/products/duero-architectural-countertop-washbasin-1610-554-205'
        }
      },
      {
        id: 2,
        videoId: 'hero-video-3',
        tag: {
          tr: '03 • MİNİMALİST HİDRODİNAMİK',
          en: '03 • MINIMALIST HYDRODYNAMICS',
          cs: '03 • MINIMALISTICKÁ HYDRODYNAMIKA'
        },
        title: {
          tr: 'Geometrik Zarafet ve Sessiz Kanalsız Hijyen Teknolojisi.',
          en: 'Geometric Elegance Meets Silent Rimless Flush Dynamics.',
          cs: 'Geometrická elegance spojená s tichou technologií splachování Rimless.'
        },
        desc: {
          tr: 'Klasik kanallı kenarları ortadan kaldıran 360° girdaplı akış dinamiği, her yıkamada %40 daha az su ile kusursuz temizlik sağlar.',
          en: 'Aerodynamic 360° vortex flow dynamics eliminating concealed bacterial rims while conserving up to 40% water per flush cycle.',
          cs: 'Aerodynamické 360° vírové splachování eliminuje skryté usazeniny a šetří až 40 % vody při každém spláchnutí.'
        },
        model: {
          badge: 'ARCHITECTURAL • 38°C',
          sku: '1654-001',
          name: {
            tr: 'Termostatik Duş Kolonu',
            en: 'Thermostatic Shower Column',
            cs: 'Termostatický sprchový sloup'
          },
          specs: {
            tr: 'Masif Pirinç • 38°C Emniyet Butonu',
            en: 'Solid Brass • 38°C Safety Stop',
            cs: 'Masivní mosaz • Bezpečnostní pojistka 38°C'
          },
          img: '/assets/images/products/lufly_2109_1654-001.jpg',
          url: '/products/thermostatic-architectural-shower-column-system-1654-001-2109'
        }
      }
    ];

    var currentIndex = 0;
    var isPaused = false;
    var duration = 7000; // 7 seconds per scene
    var startTime = null;
    var animFrame = null;

    // DOM Elements
    var videos = [
      document.getElementById('hero-video-1'),
      document.getElementById('hero-video-2'),
      document.getElementById('hero-video-3')
    ];

    var sceneTagEl = document.getElementById('hero-scene-tag');
    var sceneTitleEl = document.getElementById('hero-scene-title');
    var sceneDescEl = document.getElementById('hero-scene-desc');

    var modelCardEl = document.getElementById('hero-spotlight-card');
    var modelBadgeEl = document.getElementById('hero-spotlight-badge');
    var modelSkuEl = document.getElementById('hero-spotlight-sku');
    var modelTitleEl = document.getElementById('hero-spotlight-title');
    var modelSpecsEl = document.getElementById('hero-spotlight-specs');
    var modelImgEl = document.getElementById('hero-spotlight-img');
    var modelLinkEl = document.getElementById('hero-spotlight-link');

    var timelineTabs = document.querySelectorAll('.hero-tab-btn');
    var progressBars = document.querySelectorAll('.hero-tab-progress-fill');
    var playPauseBtn = document.getElementById('hero-play-pause-btn');

    // Theater Lightbox elements
    var watchReelBtn = document.getElementById('hero-watch-reel-btn');
    var theaterModal = document.getElementById('hero-theater-modal');
    var theaterVideo = document.getElementById('hero-theater-video');
    var closeTheaterBtn = document.getElementById('hero-theater-close');

    function switchScene(index) {
      if (index < 0) index = scenes.length - 1;
      if (index >= scenes.length) index = 0;

      currentIndex = index;
      var scene = scenes[currentIndex];

      // 1. Cross-fade Background Video
      videos.forEach(function (v, i) {
        if (!v) return;
        if (i === currentIndex) {
          v.classList.add('active');
          try {
            v.currentTime = 0;
            var playPromise = v.play();
            if (playPromise !== undefined) {
              playPromise.catch(function () {});
            }
          } catch (e) {}
        } else {
          v.classList.remove('active');
        }
      });

      // 2. Smoothly transition text content
      if (sceneTitleEl && sceneDescEl) {
        var textWrapper = sceneTitleEl.parentElement;
        if (textWrapper) {
          textWrapper.classList.add('fade-transitioning');
          setTimeout(function () {
            if (sceneTagEl) sceneTagEl.textContent = scene.tag[currentLocale] || scene.tag.tr;
            sceneTitleEl.textContent = scene.title[currentLocale] || scene.title.tr;
            sceneDescEl.textContent = scene.desc[currentLocale] || scene.desc.tr;
            textWrapper.classList.remove('fade-transitioning');
          }, 240);
        }
      }

      // 3. Smoothly transition Spotlight Model Card
      if (modelCardEl) {
        modelCardEl.classList.add('spotlight-transitioning');
        setTimeout(function () {
          if (modelBadgeEl) modelBadgeEl.textContent = scene.model.badge;
          if (modelSkuEl) modelSkuEl.textContent = 'SKU: ' + scene.model.sku;
          if (modelTitleEl) modelTitleEl.textContent = scene.model.name[currentLocale] || scene.model.name.tr;
          if (modelSpecsEl) modelSpecsEl.textContent = scene.model.specs[currentLocale] || scene.model.specs.tr;
          if (modelImgEl) {
            modelImgEl.src = scene.model.img;
            modelImgEl.alt = scene.model.name[currentLocale] || scene.model.name.tr;
          }
          if (modelLinkEl) {
            var localizedPrefix = currentLocale === 'tr' ? '' : '/' + currentLocale;
            modelLinkEl.href = localizedPrefix + scene.model.url;
          }
          modelCardEl.classList.remove('spotlight-transitioning');
        }, 240);
      }

      // 4. Update Tabs state
      timelineTabs.forEach(function (tab, i) {
        if (i === currentIndex) {
          tab.classList.add('active');
          tab.setAttribute('aria-selected', 'true');
        } else {
          tab.classList.remove('active');
          tab.setAttribute('aria-selected', 'false');
        }
      });

      // Reset progress timing
      startTime = performance.now();
    }

    // Animation loop for progress bar
    function tick(now) {
      if (!startTime) startTime = now;

      if (!isPaused) {
        var elapsed = now - startTime;
        var pct = Math.min(100, (elapsed / duration) * 100);

        progressBars.forEach(function (bar, i) {
          if (i === currentIndex) {
            bar.style.width = pct + '%';
          } else if (i < currentIndex) {
            bar.style.width = '100%';
          } else {
            bar.style.width = '0%';
          }
        });

        if (elapsed >= duration) {
          switchScene(currentIndex + 1);
        }
      }

      animFrame = requestAnimationFrame(tick);
    }

    // Timeline tab clicks
    timelineTabs.forEach(function (tab, idx) {
      tab.addEventListener('click', function () {
        switchScene(idx);
      });
    });

    // Play/Pause button
    if (playPauseBtn) {
      playPauseBtn.addEventListener('click', function () {
        isPaused = !isPaused;
        var iconPlay = playPauseBtn.querySelector('.icon-play');
        var iconPause = playPauseBtn.querySelector('.icon-pause');
        if (isPaused) {
          if (iconPlay) iconPlay.style.display = 'block';
          if (iconPause) iconPause.style.display = 'none';
          var activeVideo = videos[currentIndex];
          if (activeVideo) activeVideo.pause();
        } else {
          if (iconPlay) iconPlay.style.display = 'none';
          if (iconPause) iconPause.style.display = 'block';
          var activeVideo = videos[currentIndex];
          if (activeVideo) activeVideo.play();
          startTime = performance.now();
        }
      });
    }

    // Pause animation when hovering over model card or actions for easy reading
    if (modelCardEl) {
      modelCardEl.addEventListener('mouseenter', function () { isPaused = true; });
      modelCardEl.addEventListener('mouseleave', function () {
        if (playPauseBtn && !playPauseBtn.classList.contains('manually-paused')) {
          isPaused = false;
          startTime = performance.now();
        }
      });
    }

    // Prev / Next arrow buttons if present
    var prevBtn = document.getElementById('hero-prev-btn');
    var nextBtn = document.getElementById('hero-next-btn');
    if (prevBtn) {
      prevBtn.addEventListener('click', function () {
        switchScene(currentIndex - 1);
      });
    }
    if (nextBtn) {
      nextBtn.addEventListener('click', function () {
        switchScene(currentIndex + 1);
      });
    }

    // Theater Lightbox Modal
    if (watchReelBtn && theaterModal && theaterVideo) {
      watchReelBtn.addEventListener('click', function (e) {
        e.preventDefault();
        isPaused = true;
        theaterModal.classList.add('open');
        document.body.style.overflow = 'hidden';
        theaterVideo.currentTime = 0;
        theaterVideo.play();
      });

      function closeTheater() {
        theaterModal.classList.remove('open');
        document.body.style.overflow = '';
        theaterVideo.pause();
        isPaused = false;
        startTime = performance.now();
      }

      if (closeTheaterBtn) {
        closeTheaterBtn.addEventListener('click', closeTheater);
      }

      theaterModal.addEventListener('click', function (e) {
        if (e.target === theaterModal || e.target.classList.contains('theater-backdrop')) {
          closeTheater();
        }
      });

      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && theaterModal.classList.contains('open')) {
          closeTheater();
        }
      });
    }

    // Start playback
    switchScene(0);
    animFrame = requestAnimationFrame(tick);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHeroVideo);
  } else {
    initHeroVideo();
  }
})();
