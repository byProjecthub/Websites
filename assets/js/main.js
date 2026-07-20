// assets/js/main.js — COMPLETE FIX
document.addEventListener('DOMContentLoaded', () => {
    
    /* ========================================
       Theme Toggle (Dark / Light Mode)
       ======================================== */
    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;
    const themeIcon = themeToggle?.querySelector('i');

    const savedTheme = localStorage.getItem('vueports_theme') || 'light';
    html.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);

    themeToggle?.addEventListener('click', () => {
        const current = html.getAttribute('data-theme');
        const next = current === 'light' ? 'dark' : 'light';
        html.setAttribute('data-theme', next);
        localStorage.setItem('vueports_theme', next);
        updateThemeIcon(next);
        window.dispatchEvent(new CustomEvent('themechange', { detail: { theme: next } }));
    });

    function updateThemeIcon(theme) {
        if (!themeIcon) return;
        themeIcon.className = theme === 'light' ? 'fas fa-moon' : 'fas fa-sun';
        themeIcon.setAttribute('aria-label', theme === 'light' ? 'Switch to dark mode' : 'Switch to light mode');
    }

    /* ========================================
       Mobile Navigation
       ======================================== */
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('navMenu');
    const navLinks = navMenu?.querySelectorAll('a');

    // FIXED: Close menu on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && navMenu?.classList.contains('active')) {
            hamburger?.classList.remove('active');
            navMenu?.classList.remove('active');
            hamburger?.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }
    });

    hamburger?.addEventListener('click', () => {
        const isActive = hamburger.classList.toggle('active');
        navMenu?.classList.toggle('active');
        hamburger.setAttribute('aria-expanded', isActive ? 'true' : 'false');
        document.body.style.overflow = isActive ? 'hidden' : '';
    });

    navLinks?.forEach(link => {
        link.addEventListener('click', () => {
            hamburger?.classList.remove('active');
            navMenu?.classList.remove('active');
            hamburger?.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        });
    });

    document.addEventListener('click', (e) => {
        if (navMenu?.classList.contains('active') && 
            !navMenu.contains(e.target) && 
            !hamburger?.contains(e.target)) {
            hamburger?.classList.remove('active');
            navMenu?.classList.remove('active');
            hamburger?.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }
    });

    /* ========================================
       Navbar Scroll Effect
       ======================================== */
    const navbar = document.getElementById('navbar');
    let lastScroll = 0;
    let ticking = false;

    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                const currentScroll = window.scrollY;
                navbar?.classList.toggle('scrolled', currentScroll > 50);
                
                if (currentScroll > lastScroll && currentScroll > 200) {
                    navbar?.classList.add('nav-hidden');
                } else {
                    navbar?.classList.remove('nav-hidden');
                }
                lastScroll = currentScroll;
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });

    /* ========================================
       Stats Counter Animation — FIXED
       ======================================== */
    const statsBar = document.querySelector('.stats-bar');
    let statsAnimated = false;

    const animateStats = () => {
        if (statsAnimated) return;
        statsAnimated = true;
        
        const statItems = document.querySelectorAll('.stat-item');
        statItems.forEach((item, index) => {
            const target = parseInt(item.dataset.count || '0');
            const numEl = item.querySelector('.stat-number');
            const suffix = item.dataset.suffix || '';
            
            if (!target || !numEl) return;
            
            // FIXED: Stagger animations
            setTimeout(() => {
                let current = 0;
                const duration = 2000;
                const startTime = performance.now();
                
                const updateNumber = (currentTime) => {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    // Ease out cubic
                    const easeOut = 1 - Math.pow(1 - progress, 3);
                    current = Math.floor(target * easeOut);
                    
                    numEl.textContent = current.toLocaleString() + suffix;
                    
                    if (progress < 1) {
                        requestAnimationFrame(updateNumber);
                    } else {
                        numEl.textContent = target.toLocaleString() + suffix;
                        item.classList.add('stat-animated');
                    }
                };
                
                requestAnimationFrame(updateNumber);
            }, index * 150); // Stagger each counter
        });
    };

    if (statsBar && 'IntersectionObserver' in window) {
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateStats();
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });
        statsObserver.observe(statsBar);
    }

    /* ========================================
       Testimonial Slider — COMPLETE REWRITE
       ======================================== */
    const track = document.getElementById('testimonialsTrack');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dotsContainer = document.getElementById('sliderDots');
    
    if (track && prevBtn && nextBtn) {
        const cards = Array.from(track.querySelectorAll('.testimonial-card'));
        let currentIndex = 0;
        let autoplayInterval;
        const total = cards.length;

        if (total === 0) {
            // Hide controls if no testimonials
            if (prevBtn) prevBtn.style.display = 'none';
            if (nextBtn) nextBtn.style.display = 'none';
            if (dotsContainer) dotsContainer.style.display = 'none';
            return;
        }

        // FIXED: Calculate visible cards based on viewport
        const getVisibleCards = () => {
            if (window.innerWidth >= 1024) return 3;
            if (window.innerWidth >= 640) return 2;
            return 1;
        };

        // Create dots
        const maxIndex = Math.max(0, total - getVisibleCards());
        for (let i = 0; i <= maxIndex; i++) {
            const dot = document.createElement('button');
            dot.className = 'slider-dot' + (i === 0 ? ' active' : '');
            dot.setAttribute('aria-label', `Go to testimonial ${i + 1}`);
            dot.addEventListener('click', () => {
                goTo(i);
                resetAutoplay();
            });
            dotsContainer?.appendChild(dot);
        }

        const getCardWidth = () => {
            const card = cards[0];
            if (!card) return 0;
            const gap = 24; // FIXED: Use CSS gap value instead of margin
            return card.offsetWidth + gap;
        };

        const updateSlider = () => {
            const cardWidth = getCardWidth();
            const visible = getVisibleCards();
            const maxIdx = Math.max(0, total - visible);
            
            // FIXED: Clamp currentIndex
            currentIndex = Math.min(currentIndex, maxIdx);
            
            track.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
            track.style.transition = 'transform 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
            
            // Update dots
            dotsContainer?.querySelectorAll('.slider-dot').forEach((d, i) => {
                d.classList.toggle('active', i === currentIndex);
                d.setAttribute('aria-current', i === currentIndex ? 'true' : 'false');
            });
            
            // FIXED: Update button states with disabled attribute
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex >= maxIdx;
            prevBtn.style.opacity = currentIndex === 0 ? '0.4' : '1';
            nextBtn.style.opacity = currentIndex >= maxIdx ? '0.4' : '1';
        };

        const goTo = (index) => {
            const visible = getVisibleCards();
            const maxIdx = Math.max(0, total - visible);
            currentIndex = Math.max(0, Math.min(index, maxIdx));
            updateSlider();
        };

        const next = () => {
            const visible = getVisibleCards();
            const maxIdx = Math.max(0, total - visible);
            if (currentIndex >= maxIdx) {
                goTo(0); // FIXED: Loop back to start
            } else {
                goTo(currentIndex + 1);
            }
        };

        const prev = () => {
            if (currentIndex <= 0) {
                const visible = getVisibleCards();
                const maxIdx = Math.max(0, total - visible);
                goTo(maxIdx); // FIXED: Loop to end
            } else {
                goTo(currentIndex - 1);
            }
        };

        const startAutoplay = () => {
            autoplayInterval = setInterval(next, 5000); // FIXED: 5s instead of 6s
        };

        const resetAutoplay = () => {
            clearInterval(autoplayInterval);
            startAutoplay();
        };

        prevBtn.addEventListener('click', () => { prev(); resetAutoplay(); });
        nextBtn.addEventListener('click', () => { next(); resetAutoplay(); });
        
        // Keyboard navigation
        track?.parentElement?.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') { prev(); resetAutoplay(); }
            if (e.key === 'ArrowRight') { next(); resetAutoplay(); }
        });

        // Touch/swipe support — FIXED: Better touch handling
        let touchStartX = 0;
        let touchEndX = 0;
        let isDragging = false;
        
        track?.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
            isDragging = true;
        }, { passive: true });
        
        track?.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            touchEndX = e.changedTouches[0].screenX;
        }, { passive: true });
        
        track?.addEventListener('touchend', (e) => {
            if (!isDragging) return;
            isDragging = false;
            const diff = touchStartX - touchEndX;
            if (Math.abs(diff) > 50) {
                diff > 0 ? next() : prev();
                resetAutoplay();
            }
        }, { passive: true });

        // Pause on hover
        const sliderContainer = track?.parentElement;
        sliderContainer?.addEventListener('mouseenter', () => clearInterval(autoplayInterval));
        sliderContainer?.addEventListener('mouseleave', startAutoplay);

        // FIXED: Handle resize
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                // Recreate dots for new visible count
                if (dotsContainer) dotsContainer.innerHTML = '';
                const newMax = Math.max(0, total - getVisibleCards());
                for (let i = 0; i <= newMax; i++) {
                    const dot = document.createElement('button');
                    dot.className = 'slider-dot' + (i === currentIndex ? ' active' : '');
                    dot.setAttribute('aria-label', `Go to testimonial ${i + 1}`);
                    dot.addEventListener('click', () => {
                        goTo(i);
                        resetAutoplay();
                    });
                    dotsContainer?.appendChild(dot);
                }
                updateSlider();
            }, 250);
        });

        updateSlider();
        startAutoplay();
    }

    /* ========================================
       Typewriter Effect — FIXED
       ======================================== */
    const typewriter = document.getElementById('typewriter');
    if (typewriter) {
        // FIXED: Fallback words if data-words missing
        let words;
        try {
            words = JSON.parse(typewriter.dataset.words || '["Software Architect", "Data Engineer", "AI Agent Builder", "Cloud Specialist"]');
        } catch {
            words = ["Software Architect", "Data Engineer", "AI Agent Builder", "Cloud Specialist"];
        }
        
        let wordIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        let typeTimeout;
        let isPaused = false;
        
        const type = () => {
            if (isPaused) return;
            
            const current = words[wordIndex];
            const displayText = isDeleting 
                ? current.substring(0, charIndex - 1)
                : current.substring(0, charIndex + 1);
            
            typewriter.textContent = displayText;
            typewriter.setAttribute('aria-label', `Current role: ${displayText}`);
            
            const typeSpeed = isDeleting ? 50 : 100;
            
            if (!isDeleting && charIndex < current.length) {
                charIndex++;
                typeTimeout = setTimeout(type, typeSpeed);
            } else if (isDeleting && charIndex > 0) {
                charIndex--;
                typeTimeout = setTimeout(type, typeSpeed);
            } else {
                isDeleting = !isDeleting;
                if (!isDeleting) {
                    wordIndex = (wordIndex + 1) % words.length;
                }
                typeTimeout = setTimeout(type, isDeleting ? 2000 : 500);
            }
        };
        
        type();
        
        // Pause when not visible
        if ('IntersectionObserver' in window) {
            const typeObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (!entry.isIntersecting) {
                        isPaused = true;
                        clearTimeout(typeTimeout);
                    } else {
                        isPaused = false;
                        if (!typewriter.textContent) type();
                    }
                });
            }, { threshold: 0.1 });
            typeObserver.observe(typewriter);
        }
    }

    /* ========================================
       FAQ Accordion — NEW: Was completely missing
       ======================================== */
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        question?.addEventListener('click', () => {
            const isActive = item.classList.contains('active');
            
            // Close all others (optional accordion behavior)
            faqItems.forEach(other => {
                if (other !== item) other.classList.remove('active');
            });
            
            item.classList.toggle('active', !isActive);
        });
    });

    /* ========================================
       Toast Notification System — FIXED
       ======================================== */
    window.showToast = (message, type = 'success', duration = 3000) => {
        let toast = document.getElementById('toast');
        
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'toast';
            document.body.appendChild(toast);
        }
        
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };
        
        const colors = {
            success: '#10b981',
            error: '#ef4444',
            warning: '#f59e0b',
            info: '#3b82f6'
        };
        
        toast.innerHTML = `
            <i class="fas ${icons[type] || icons.info}" style="margin-right: 10px;"></i>
            <span>${message}</span>
        `;
        
        toast.style.cssText = `
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: ${colors[type] || colors.info};
            color: white;
            padding: 14px 24px;
            border-radius: 12px;
            font-weight: 500;
            font-size: 14px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            z-index: 9999;
            display: flex;
            align-items: center;
            transform: translateX(150%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            max-width: 400px;
            word-wrap: break-word;
        `;
        
        requestAnimationFrame(() => {
            toast.style.transform = 'translateX(0)';
        });
        
        const hideTimeout = setTimeout(() => {
            toast.style.transform = 'translateX(150%)';
            setTimeout(() => { toast.style.display = 'none'; }, 400);
        }, duration);
        
        toast.addEventListener('click', () => {
            clearTimeout(hideTimeout);
            toast.style.transform = 'translateX(150%)';
        }, { once: true });
    };

    /* ========================================
       Scroll Animations — FIXED
       ======================================== */
    const animateElements = document.querySelectorAll('.animate-on-scroll, .animate');
    
    if ('IntersectionObserver' in window) {
        const scrollObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const delay = parseInt(el.dataset.delay || '0');
                    
                    setTimeout(() => {
                        el.classList.add('visible', 'animated');
                    }, delay);
                    
                    if (!el.dataset.repeat) {
                        scrollObserver.unobserve(el);
                    }
                } else if (el.dataset.repeat) {
                    entry.target.classList.remove('visible', 'animated');
                }
            });
        }, { 
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        animateElements.forEach(el => scrollObserver.observe(el));
    } else {
        animateElements.forEach(el => el.classList.add('visible'));
    }

    /* ========================================
       Smooth Scroll — FIXED
       ======================================== */
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                const navHeight = navbar?.offsetHeight || 0;
                const targetPosition = target.getBoundingClientRect().top + window.scrollY - navHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                
                history.pushState(null, '', targetId);
            }
        });
    });

    /* ========================================
       Form Validation Helpers
       ======================================== */
    window.validateEmail = (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    window.validatePhone = (phone) => /^(\+27|0)[6-8][0-9]{8}$/.test(phone.replace(/\s/g, ''));
    window.validateRequired = (value) => value.trim().length > 0;

    /* ========================================
       AJAX Form Submit — FIXED
       ======================================== */
    window.submitFormAjax = async (form, options = {}) => {
        const { 
            onSuccess = () => {},
            onError = () => {},
            showLoading = true 
        } = options;
        
        const submitBtn = form.querySelector('[type="submit"]');
        const originalText = submitBtn?.innerHTML || 'Submit';
        
        if (showLoading && submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        }
        
        try {
            const formData = new FormData(form);
            const response = await fetch(form.action || window.location.href, {
                method: form.method || 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            
            let data;
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                data = await response.json();
            } else {
                data = { success: response.ok, message: response.ok ? 'Success!' : 'Request failed' };
            }
            
            if (data.success) {
                window.showToast(data.message || 'Success!', 'success');
                onSuccess(data);
                if (data.redirect) {
                    setTimeout(() => window.location.href = data.redirect, 1500);
                }
            } else {
                window.showToast(data.message || 'Something went wrong.', 'error');
                onError(data);
            }
            
            return data;
        } catch (err) {
            window.showToast('Network error. Please try again.', 'error');
            onError({ error: err.message });
            return { success: false, error: err.message };
        } finally {
            if (showLoading && submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        }
    };

    /* ========================================
       Calculator — FIXED
       ======================================== */
    const calculatorForm = document.getElementById('projectCalculator');
    if (calculatorForm) {
        const serviceSelect = calculatorForm.querySelector('[name="service_type"]');
        const complexitySelect = calculatorForm.querySelector('[name="complexity"]');
        const featuresCheckboxes = calculatorForm.querySelectorAll('[name="features[]"]');
        const resultDisplay = document.getElementById('calculatorResult');
        
        const calculateEstimate = () => {
            const service = serviceSelect?.value;
            const complexity = complexitySelect?.value || 'medium';
            
            const basePrices = {
                'custom-software-web': { min: 15000, max: 250000 },
                'data-engineering-analytics': { min: 25000, max: 350000 },
                'ai-agent-development': { min: 20000, max: 400000 }
            };
            
            const complexityMultipliers = {
                'low': 0.7,
                'medium': 1.0,
                'high': 1.5,
                'enterprise': 2.5
            };
            
            const base = basePrices[service] || { min: 10000, max: 100000 };
            const multiplier = complexityMultipliers[complexity] || 1.0;
            
            let featureAdd = 0;
            featuresCheckboxes?.forEach(cb => {
                if (cb.checked) featureAdd += parseInt(cb.dataset.price || '0');
            });
            
            const min = Math.round(base.min * multiplier + featureAdd);
            const max = Math.round(base.max * multiplier + featureAdd);
            
            if (resultDisplay) {
                resultDisplay.innerHTML = `
                    <div class="calculator-result">
                        <div class="result-label">Estimated Investment</div>
                        <div class="result-range">R${min.toLocaleString()} — R${max.toLocaleString()}</div>
                        <div class="result-note">Final quote after scoping session</div>
                    </div>
                `;
                resultDisplay.style.display = 'block';
            }
            
            return { min, max };
        };
        
        serviceSelect?.addEventListener('change', calculateEstimate);
        complexitySelect?.addEventListener('change', calculateEstimate);
        featuresCheckboxes?.forEach(cb => cb.addEventListener('change', calculateEstimate));
    }

    /* ========================================
       Booking Calendar — FIXED
       ======================================== */
    const bookingDateInput = document.querySelector('[name="booking_date"]');
    if (bookingDateInput) {
        const today = new Date().toISOString().split('T')[0];
        bookingDateInput.setAttribute('min', today);
        
        bookingDateInput.addEventListener('change', async (e) => {
            const timeSelect = document.querySelector('[name="booking_time"]');
            if (!timeSelect) return;
            
            timeSelect.innerHTML = '<option value="">Loading slots...</option>';
            timeSelect.disabled = true;
            
            try {
                const response = await fetch(`api/v1/bookings.php?date=${e.target.value}`);
                if (!response.ok) throw new Error('Failed to load');
                
                const data = await response.json();
                
                timeSelect.innerHTML = '<option value="">Select a time</option>';
                data.slots?.forEach(slot => {
                    const option = document.createElement('option');
                    option.value = slot.time;
                    option.textContent = slot.time + (slot.available ? '' : ' (Booked)');
                    option.disabled = !slot.available;
                    timeSelect.appendChild(option);
                });
                
                timeSelect.disabled = false;
            } catch (err) {
                timeSelect.innerHTML = '<option value="">Error loading slots</option>';
                console.error('Booking slots error:', err);
            }
        });
    }

    /* ========================================
       reCAPTCHA v3 — FIXED
       ======================================== */
    const formsWithRecaptcha = document.querySelectorAll('form[data-recaptcha]');
    formsWithRecaptcha.forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            if (typeof grecaptcha === 'undefined') {
                console.warn('reCAPTCHA not loaded, submitting without');
                form.submit();
                return;
            }
            
            try {
                const siteKey = document.querySelector('[data-recaptcha-site-key]')?.dataset.recaptchaSiteKey;
                if (!siteKey) throw new Error('No site key found');
                
                const token = await grecaptcha.execute(siteKey, { 
                    action: form.dataset.recaptchaAction || 'submit' 
                });
                
                let input = form.querySelector('input[name="recaptcha_token"]');
                if (!input) {
                    input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'recaptcha_token';
                    form.appendChild(input);
                }
                input.value = token;
                
                form.submit();
            } catch (err) {
                console.error('reCAPTCHA error:', err);
                window.showToast('Security check failed. Please refresh and try again.', 'error');
            }
        });
    });

    /* ========================================
       Lazy Loading Images — FIXED
       ======================================== */
    if ('IntersectionObserver' in window) {
        const lazyImages = document.querySelectorAll('img[data-src]');
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    img.classList.add('loaded');
                    img.addEventListener('load', () => img.classList.add('img-loaded'), { once: true });
                    imageObserver.unobserve(img);
                }
            });
        }, { rootMargin: '100px' }); // FIXED: Increased margin for earlier loading
        
        lazyImages.forEach(img => imageObserver.observe(img));
    }

    /* ========================================
       Back to Top — FIXED
       ======================================== */
    const backToTop = document.getElementById('backToTop');
    if (backToTop) {
        // Show/hide with IntersectionObserver for better performance
        const scrollObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                backToTop.classList.toggle('visible', !entry.isIntersecting);
            });
        }, { threshold: 0 });
        
        // Observe hero section or first element
        const hero = document.querySelector('.hero');
        if (hero) scrollObserver.observe(hero);
        
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    /* ========================================
       Copy to Clipboard — FIXED
       ======================================== */
    window.copyToClipboard = async (text, successMessage = 'Copied!') => {
        try {
            await navigator.clipboard.writeText(text);
            window.showToast(successMessage, 'success');
            return true;
        } catch (err) {
            // Fallback
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.cssText = 'position:fixed;opacity:0;pointer-events:none;';
            document.body.appendChild(textarea);
            textarea.select();
            const success = document.execCommand('copy');
            document.body.removeChild(textarea);
            
            if (success) {
                window.showToast(successMessage, 'success');
                return true;
            }
            window.showToast('Failed to copy', 'error');
            return false;
        }
    };
function calculateEstimate() {
    const service = document.getElementById('calc-service')?.value;
    const complexity = document.getElementById('calc-complexity')?.value || 'medium';
    const checkboxes = document.querySelectorAll('#projectCalculator [name="features[]"]:checked');
    const resultDisplay = document.getElementById('calculatorResult');
    
    if (!service) {
        window.showToast('Please select a service type', 'warning');
        return;
    }
    
    const basePrices = {
        'custom-software-web': { min: 15000, max: 250000 },
        'data-engineering-analytics': { min: 25000, max: 350000 },
        'ai-agent-development': { min: 20000, max: 400000 }
    };
    
    const multipliers = { 'low': 0.7, 'medium': 1.0, 'high': 1.5, 'enterprise': 2.5 };
    
    const base = basePrices[service] || { min: 10000, max: 100000 };
    const mult = multipliers[complexity] || 1.0;
    
    let featureAdd = 0;
    checkboxes.forEach(cb => featureAdd += parseInt(cb.dataset.price || '0'));
    
    const min = Math.round(base.min * mult + featureAdd);
    const max = Math.round(base.max * mult + featureAdd);
    
    if (resultDisplay) {
        resultDisplay.innerHTML = `
            <div class="result-label">Estimated Investment</div>
            <div class="result-range">R${min.toLocaleString()} — R${max.toLocaleString()}</div>
            <div class="result-note">Final quote after scoping session</div>
        `;
        resultDisplay.style.display = 'block';
        resultDisplay.classList.add('animate-on-scroll', 'visible');
    }
}
    /* ========================================
       Print Helper
       ======================================== */
    window.printPage = () => window.print();

    /* ========================================
       Initialize Tooltips — FIXED
       ======================================== */
    document.querySelectorAll('[data-tooltip]').forEach(el => {
        let tooltip = null;
        
        el.addEventListener('mouseenter', () => {
            tooltip = document.createElement('div');
            tooltip.className = 'tooltip-dynamic';
            tooltip.textContent = el.dataset.tooltip;
            tooltip.style.cssText = `
                position: absolute;
                background: #0f172a;
                color: white;
                padding: 6px 12px;
                border-radius: 6px;
                font-size: 12px;
                z-index: 1000;
                pointer-events: none;
                white-space: nowrap;
                opacity: 0;
                transform: translateY(4px);
                transition: opacity 0.2s, transform 0.2s;
            `;
            document.body.appendChild(tooltip);
            
            const rect = el.getBoundingClientRect();
            const tooltipRect = tooltip.getBoundingClientRect();
            
            let left = rect.left + (rect.width / 2) - (tooltipRect.width / 2);
            let top = rect.top - tooltipRect.height - 8;
            
            // Keep in viewport
            left = Math.max(8, Math.min(left, window.innerWidth - tooltipRect.width - 8));
            if (top < 8) top = rect.bottom + 8;
            
            tooltip.style.left = left + 'px';
            tooltip.style.top = top + window.scrollY + 'px';
            
            requestAnimationFrame(() => {
                tooltip.style.opacity = '1';
                tooltip.style.transform = 'translateY(0)';
            });
        });
        
        el.addEventListener('mouseleave', () => {
            if (tooltip) {
                tooltip.style.opacity = '0';
                setTimeout(() => tooltip?.remove(), 200);
                tooltip = null;
            }
        });
    });

    console.log('✅ Vueports Solutions v1.1 — All systems ready');
});

// Cookie Consent Banner
(function() {
    const banner = document.createElement('div');
    banner.className = 'cookie-banner';
    banner.innerHTML = `
        <div class="container">
            <p>We use cookies to enhance your experience. By continuing, you agree to our 
                <a href="legal/cookies.php">Cookie Policy</a> and 
                <a href="legal/privacy.php">Privacy Policy</a>.
            </p>
            <div class="cookie-actions">
                <button class="btn btn-outline btn-sm" id="cookieReject">Essential Only</button>
                <button class="btn btn-primary btn-sm" id="cookieAccept">Accept All</button>
            </div>
        </div>
    `;
    document.body.appendChild(banner);

    const consentKey = 'vueports_consent';
    const consent = localStorage.getItem(consentKey);

    if (!consent) {
        setTimeout(() => banner.classList.add('active'), 1000);
    }

    document.getElementById('cookieAccept').addEventListener('click', () => {
        localStorage.setItem(consentKey, JSON.stringify({ essential: true, analytics: true, functional: true, date: new Date().toISOString() }));
        banner.classList.remove('active');
        showToast('Cookies accepted. Thank you!');
        // Initialize analytics here if needed
    });

    document.getElementById('cookieReject').addEventListener('click', () => {
        localStorage.setItem(consentKey, JSON.stringify({ essential: true, analytics: false, functional: false, date: new Date().toISOString() }));
        banner.classList.remove('active');
        showToast('Only essential cookies enabled.');
    });
})();

// Toast Notification
function showToast(message) {
    const toast = document.getElementById('toast');
    if (!toast) return;
    toast.textContent = message;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 4000);
}

// FAQ Accordion
document.querySelectorAll('.faq-question').forEach(btn => {
    btn.addEventListener('click', () => {
        const isExpanded = btn.getAttribute('aria-expanded') === 'true';
        const answer = document.getElementById(btn.getAttribute('aria-controls'));
        
        // Close all others
        document.querySelectorAll('.faq-question').forEach(b => {
            b.setAttribute('aria-expanded', 'false');
            const a = document.getElementById(b.getAttribute('aria-controls'));
            if (a) a.classList.remove('active');
        });
        
        if (!isExpanded) {
            btn.setAttribute('aria-expanded', 'true');
            answer.classList.add('active');
        }
    });
});

// Testimonials Slider
(function() {
    const track = document.getElementById('testimonialsTrack');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dotsContainer = document.getElementById('sliderDots');
    
    if (!track || !prevBtn || !nextBtn) return;
    
    const cards = track.children;
    let currentIndex = 0;
    
    // Create dots
    for (let i = 0; i < cards.length; i++) {
        const dot = document.createElement('button');
        dot.className = 'slider-dot' + (i === 0 ? ' active' : '');
        dot.setAttribute('aria-label', `Go to testimonial ${i + 1}`);
        dot.addEventListener('click', () => goToSlide(i));
        dotsContainer.appendChild(dot);
    }
    
    const dots = dotsContainer.children;
    
    function getItemsPerView() {
        if (window.innerWidth >= 1024) return 3;
        if (window.innerWidth >= 768) return 2;
        return 1;
    }
    
    function goToSlide(index) {
        const itemsPerView = getItemsPerView();
        const maxIndex = Math.max(0, cards.length - itemsPerView);
        currentIndex = Math.min(Math.max(index, 0), maxIndex);
        const gap = 24;
        const cardWidth = cards[0].offsetWidth + gap;
        track.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
        
        Array.from(dots).forEach((d, i) => d.classList.toggle('active', i === currentIndex));
    }
    
    prevBtn.addEventListener('click', () => goToSlide(currentIndex - 1));
    nextBtn.addEventListener('click', () => goToSlide(currentIndex + 1));
    
    // Auto-play
    let autoplay = setInterval(() => goToSlide(currentIndex + 1), 5000);
    track.parentElement.addEventListener('mouseenter', () => clearInterval(autoplay));
    track.parentElement.addEventListener('mouseleave', () => {
        autoplay = setInterval(() => goToSlide(currentIndex + 1), 5000);
    });
    
    window.addEventListener('resize', () => goToSlide(currentIndex));
})();

// Stats Counter Animation
(function() {
    const stats = document.querySelectorAll('.stat-item');
    if (!stats.length) return;
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const item = entry.target;
                const target = parseInt(item.dataset.count);
                const suffix = item.dataset.suffix || '';
                const numberEl = item.querySelector('.stat-number');
                let current = 0;
                const increment = target / 50;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    numberEl.textContent = Math.floor(current) + suffix;
                }, 30);
                observer.unobserve(item);
            }
        });
    }, { threshold: 0.5 });
    
    stats.forEach(stat => observer.observe(stat));
})();

// Back to Top
const backToTop = document.getElementById('backToTop');
if (backToTop) {
    window.addEventListener('scroll', () => {
        backToTop.style.display = window.scrollY > 500 ? 'flex' : 'none';
    });
    backToTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

// Theme Toggle
const themeToggle = document.getElementById('themeToggle');
if (themeToggle) {
    const html = document.documentElement;
    const savedTheme = localStorage.getItem('vueports_theme') || 'light';
    html.setAttribute('data-theme', savedTheme);
    
    themeToggle.addEventListener('click', () => {
        const current = html.getAttribute('data-theme');
        const next = current === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', next);
        localStorage.setItem('vueports_theme', next);
        themeToggle.innerHTML = `<i class="fas fa-${next === 'dark' ? 'sun' : 'moon'}"></i>`;
    });
    
    themeToggle.innerHTML = `<i class="fas fa-${savedTheme === 'dark' ? 'sun' : 'moon'}"></i>`;
}

// Mobile Menu
const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('navMenu');
if (hamburger && navMenu) {
    hamburger.addEventListener('click', () => {
        const expanded = hamburger.getAttribute('aria-expanded') === 'true';
        hamburger.setAttribute('aria-expanded', !expanded);
        navMenu.classList.toggle('active');
    });
}

// Scroll animations
const animateOnScroll = document.querySelectorAll('.animate-on-scroll');
const scrollObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animated');
            scrollObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.1 });

animateOnScroll.forEach(el => scrollObserver.observe(el));

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});