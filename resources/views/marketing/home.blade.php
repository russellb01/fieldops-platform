<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Loudon Mechanical Services | HVAC, Refrigeration & Restaurant Equipment Service</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Loudon Mechanical Services provides HVAC, commercial refrigeration, walk-in cooler repair, walk-in freezer repair, ice machine service, restaurant equipment repair, preventive maintenance, repair, and installation across East Tennessee. Licensed, insured, bonded, with 30+ years of experience.">
    <meta name="keywords" content="Loudon Mechanical Services, HVAC Loudon TN, commercial refrigeration Loudon TN, walk-in cooler repair, walk-in freezer repair, ice machine service, restaurant equipment repair, AC repair, heat pump repair, preventive maintenance">
    <meta name="theme-color" content="#061827">

    <meta property="og:title" content="Loudon Mechanical Services">
    <meta property="og:description" content="Premium HVAC, refrigeration, ice machine, restaurant equipment, and preventive maintenance service.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">

    <link rel="canonical" href="{{ url('/') }}">
    <link rel="stylesheet" href="{{ asset('css/lms.css') }}">
    <script defer src="{{ asset('js/lms.js') }}"></script>

    @php
        $logoCandidates = [
            'images/lms/logo.png',
            'images/lms/logo.jpg',
            'images/lms/logo.webp',
            'images/logo.png',
            'images/logo.jpg',
            'images/logo.webp',
            'logo.png',
            'logo.jpg',
            'logo.webp',
        ];

        $logoPath = collect($logoCandidates)->first(fn ($path) => file_exists(public_path($path)));
    @endphp

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "HVACBusiness",
        "name": "Loudon Mechanical Services",
        "url": "{{ url('/') }}",
        "telephone": "+1-865-964-6348",
        "description": "HVAC, commercial refrigeration, ice machine, restaurant equipment, repair, installation, and preventive maintenance service.",
        "areaServed": [
            "Loudon County TN",
            "Lenoir City TN",
            "Loudon TN",
            "Tellico Village TN",
            "Knoxville TN",
            "Maryville TN",
            "Oak Ridge TN",
            "East Tennessee"
        ],
        "parentOrganization": {
            "@type": "Organization",
            "name": "Volunteer Technology Systems"
        },
        "priceRange": "$$"
    }
    </script>
</head>

<body>
    <a class="skip-link" href="#main">Skip to content</a>

    <div class="top-strip">
        <div class="container top-strip__inner">
            <span>Licensed • Insured • Bonded</span>
            <span>30+ Years Experience</span>
            <span>HVAC • Refrigeration • Restaurant Equipment</span>
        </div>
    </div>

    <header class="site-header" data-header>
        <div class="container nav">
            <a class="brand" href="{{ route('home') }}" aria-label="Loudon Mechanical Services home">
                <div class="brand__mark {{ $logoPath ? 'brand__mark--logo' : '' }}">
                    @if ($logoPath)
                        <img src="{{ asset($logoPath) }}" alt="Loudon Mechanical Services logo">
                    @else
                        <span>LMS</span>
                    @endif
                </div>
                <div class="brand__text">
                    <strong>Loudon Mechanical Services</strong>
                    <small>Powered by Volunteer Technology Systems</small>
                </div>
            </a>

            <button class="nav-toggle" type="button" aria-label="Open menu" data-nav-toggle>
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav class="nav-links" data-nav-links>
                <a href="#services">Services</a>
                <a href="#refrigeration">Refrigeration</a>
                <a href="#equipment">Equipment</a>
                <a href="#maintenance">Maintenance</a>
                <a href="#coverage">Coverage</a>
                <a href="#platform">Platform</a>
                <a class="nav-call" href="tel:8659646348">Call 865-964-6348</a>
            </nav>
        </div>
    </header>

    <main id="main">
        <section class="hero">
            <div class="hero__glow hero__glow--one"></div>
            <div class="hero__glow hero__glow--two"></div>

            <div class="container hero__grid">
                <div class="hero__content reveal">
                    <p class="eyebrow">HVAC • Refrigeration • Commercial Equipment</p>
                    <h1>Mechanical service built for real-world breakdowns, not generic contractor promises.</h1>
                    <p class="hero__lead">
                        Loudon Mechanical Services keeps homes comfortable, commercial kitchens running,
                        coolers cold, freezers protected, and ice machines producing across East Tennessee.
                    </p>

                    <div class="hero__actions">
                        <a class="btn btn--primary" href="tel:8659646348">Call 865-964-6348</a>
                        <a class="btn btn--secondary" href="#services">View Services</a>
                    </div>

                    <div class="hero__proof">
                        <div>
                            <strong>30+</strong>
                            <span>Years Experience</span>
                        </div>
                        <div>
                            <strong>24/7</strong>
                            <span>Urgent Service Focus</span>
                        </div>
                        <div>
                            <strong>VTS</strong>
                            <span>Technology-backed Platform</span>
                        </div>
                    </div>
                </div>

                <div class="hero__panel reveal reveal--delay">
                    <div class="hero-visual">
                        <img src="{{ asset('images/lms/field-service-dashboard.svg') }}" alt="Loudon Mechanical Services field service platform dashboard illustration">
                        <div class="hero-visual__badge hero-visual__badge--top">
                            <span>Critical Service</span>
                            <strong>Refrigeration First</strong>
                        </div>
                        <div class="hero-visual__badge hero-visual__badge--bottom">
                            <span>Call Now</span>
                            <strong>865-964-6348</strong>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="trust-band">
            <div class="container trust-band__grid">
                <div>
                    <strong>Licensed</strong>
                    <span>Professional mechanical service</span>
                </div>
                <div>
                    <strong>Insured</strong>
                    <span>Protected for serious work</span>
                </div>
                <div>
                    <strong>Bonded</strong>
                    <span>Built on accountability</span>
                </div>
                <div>
                    <strong>Experienced</strong>
                    <span>30+ years in the field</span>
                </div>
            </div>
        </section>

        <section class="section section--light" id="services">
            <div class="container">
                <div class="section-heading reveal">
                    <p class="eyebrow">What We Service</p>
                    <h2>One call for HVAC, refrigeration, ice machines, and commercial kitchen equipment.</h2>
                    <p>
                        LMS is built around real mechanical service: diagnostics, repairs, installation,
                        preventive maintenance, and support for the equipment that keeps homes and businesses running.
                    </p>
                </div>

                <div class="service-grid service-grid--visual">
                    <article class="visual-service-card visual-service-card--large reveal">
                        <img src="{{ asset('images/lms/commercial-refrigeration.svg') }}" alt="Commercial refrigeration service illustration">
                        <div>
                            <span>High Priority</span>
                            <h3>Commercial Refrigeration</h3>
                            <p>Walk-in coolers, walk-in freezers, reach-ins, prep tables, defrost issues, temperature problems, and urgent diagnostics.</p>
                        </div>
                    </article>

                    <article class="visual-service-card reveal">
                        <img src="{{ asset('images/lms/hvac-service.svg') }}" alt="HVAC service illustration">
                        <div>
                            <span>Comfort Systems</span>
                            <h3>HVAC Service</h3>
                            <p>Air conditioning, heating, heat pumps, airflow issues, maintenance, repair, and replacement guidance.</p>
                        </div>
                    </article>

                    <article class="visual-service-card reveal">
                        <img src="{{ asset('images/lms/restaurant-equipment.svg') }}" alt="Restaurant equipment service illustration">
                        <div>
                            <span>Kitchen Equipment</span>
                            <h3>Restaurant Equipment</h3>
                            <p>Stoves, ovens, fryers, grills, griddles, and commercial kitchen equipment service.</p>
                        </div>
                    </article>
                </div>

                <div class="service-grid service-grid--compact">
                    <article class="service-card reveal">
                        <div class="service-card__icon">❄</div>
                        <h3>Air Conditioning</h3>
                        <p>AC repair, seasonal tune-ups, system diagnostics, airflow issues, and reliable cooling support.</p>
                    </article>

                    <article class="service-card reveal">
                        <div class="service-card__icon">🔥</div>
                        <h3>Heating & Heat Pumps</h3>
                        <p>Heating service, heat pump repair, thermostat issues, comfort problems, and winter readiness.</p>
                    </article>

                    <article class="service-card service-card--featured reveal">
                        <div class="service-card__icon">▣</div>
                        <h3>Refrigeration</h3>
                        <p>Walk-in coolers, freezers, reach-ins, prep tables, temperature problems, and diagnostics.</p>
                    </article>

                    <article class="service-card reveal">
                        <div class="service-card__icon">◈</div>
                        <h3>Ice Machines</h3>
                        <p>Cleaning, service, repair, water-flow issues, production problems, and preventive maintenance.</p>
                    </article>

                    <article class="service-card reveal">
                        <div class="service-card__icon">◉</div>
                        <h3>Commercial Cooking</h3>
                        <p>Stoves, ovens, fryers, grills, griddles, and other high-use commercial equipment.</p>
                    </article>

                    <article class="service-card reveal">
                        <div class="service-card__icon">✓</div>
                        <h3>Maintenance Plans</h3>
                        <p>Regular cleaning and maintenance to reduce breakdowns, improve performance, and extend equipment life.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section section--dark" id="refrigeration">
            <div class="container split">
                <div class="split__content reveal">
                    <p class="eyebrow">Refrigeration Heavy</p>
                    <h2>When cold storage fails, every minute matters.</h2>
                    <p>
                        Commercial refrigeration is one of the most important parts of LMS.
                        Restaurants, markets, kitchens, and businesses need fast diagnostics,
                        honest repair guidance, and maintenance that protects inventory.
                    </p>

                    <div class="check-list">
                        <span>Walk-in cooler and freezer repair</span>
                        <span>Reach-in coolers and prep tables</span>
                        <span>Ice machine service and cleaning</span>
                        <span>Temperature, airflow, compressor, and defrost issues</span>
                        <span>Preventive maintenance for high-use equipment</span>
                    </div>
                </div>

                <div class="image-panel reveal reveal--delay">
                    <img src="{{ asset('images/lms/commercial-refrigeration.svg') }}" alt="Walk-in cooler and freezer service illustration">
                    <div class="image-panel__overlay">
                        <span>Critical Call</span>
                        <strong>Cooler not holding temperature?</strong>
                        <p>Protect product, reduce downtime, and find the real cause — not just the symptom.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section section--white" id="equipment">
            <div class="container equipment-showcase">
                <div class="section-heading reveal">
                    <p class="eyebrow">Commercial Equipment</p>
                    <h2>Built for restaurants, kitchens, facilities, and businesses that cannot afford downtime.</h2>
                    <p>
                        LMS handles more than comfort systems. We service the equipment that keeps commercial operations open:
                        refrigeration, ice, cooking equipment, and the maintenance that keeps it all working.
                    </p>
                </div>

                <div class="equipment-grid">
                    <article class="equipment-card reveal">
                        <img src="{{ asset('images/lms/restaurant-equipment.svg') }}" alt="Commercial restaurant equipment illustration">
                        <h3>Cooking Equipment</h3>
                        <p>Stoves, ovens, fryers, grills, griddles, and other high-use kitchen equipment.</p>
                    </article>

                    <article class="equipment-card reveal">
                        <img src="{{ asset('images/lms/maintenance-cleaning.svg') }}" alt="Preventive maintenance illustration">
                        <h3>Cleaning & Maintenance</h3>
                        <p>Coil cleaning, inspections, temperature checks, and preventive service documentation.</p>
                    </article>

                    <article class="equipment-card reveal">
                        <img src="{{ asset('images/lms/service-van.svg') }}" alt="Local field service vehicle illustration">
                        <h3>Local Field Service</h3>
                        <p>East Tennessee service coverage with direct phone support and practical field experience.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section section--light" id="maintenance">
            <div class="container maintenance">
                <div class="maintenance__panel reveal">
                    <p class="eyebrow">Preventive Maintenance</p>
                    <h2>Maintenance is cheaper than downtime.</h2>
                    <p>
                        Proper cleaning and regular service help HVAC and refrigeration systems run cleaner,
                        colder, safer, and more efficiently. LMS helps catch problems before they turn into emergency calls.
                    </p>
                    <a class="btn btn--primary" href="tel:8659646348">Schedule Maintenance</a>
                </div>

                <div class="maintenance__items">
                    <div class="mini-card reveal">
                        <strong>Clean coils</strong>
                        <span>Improve airflow and system performance.</span>
                    </div>
                    <div class="mini-card reveal">
                        <strong>Check temperatures</strong>
                        <span>Catch weak cooling before inventory is at risk.</span>
                    </div>
                    <div class="mini-card reveal">
                        <strong>Inspect components</strong>
                        <span>Find worn parts before they shut equipment down.</span>
                    </div>
                    <div class="mini-card reveal">
                        <strong>Document service</strong>
                        <span>Build a better maintenance history over time.</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="section section--white" id="coverage">
            <div class="container coverage">
                <div class="section-heading reveal">
                    <p class="eyebrow">Service Area</p>
                    <h2>Serving Loudon County and the surrounding East Tennessee region.</h2>
                    <p>
                        Local service with a modern platform foundation — built for homeowners, restaurants,
                        commercial kitchens, facilities, and businesses that depend on working equipment.
                    </p>
                </div>

                <div class="coverage-grid reveal">
                    <span>Loudon</span>
                    <span>Lenoir City</span>
                    <span>Tellico Village</span>
                    <span>Philadelphia</span>
                    <span>Greenback</span>
                    <span>Knoxville</span>
                    <span>Maryville</span>
                    <span>Oak Ridge</span>
                    <span>East Tennessee</span>
                </div>
            </div>
        </section>

        <section class="section section--portal" id="platform">
            <div class="container portal">
                <div class="portal__content reveal">
                    <p class="eyebrow">Built Under Volunteer Technology Systems</p>
                    <h2>More than a website — this is the beginning of a field service platform.</h2>
                    <p>
                        Loudon Mechanical Services is being built on a modern foundation for service requests,
                        customer communication, job tracking, equipment history, maintenance reminders,
                        and future customer portal tools.
                    </p>
                </div>

                <div class="portal__timeline reveal reveal--delay">
                    <div>
                        <span>Now</span>
                        <strong>Premium public website</strong>
                        <p>Clear services, strong SEO, mobile-friendly CTAs, and commercial-focused messaging.</p>
                    </div>
                    <div>
                        <span>Next</span>
                        <strong>Customer request flow</strong>
                        <p>Simple service request intake for HVAC, refrigeration, and equipment problems.</p>
                    </div>
                    <div>
                        <span>Future</span>
                        <strong>Field service software</strong>
                        <p>Equipment records, service history, maintenance tracking, and smarter dispatch tools.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="final-cta">
            <div class="container final-cta__inner reveal">
                <p class="eyebrow">Need Service?</p>
                <h2>Call Loudon Mechanical Services before a small problem becomes expensive downtime.</h2>
                <div class="final-cta__actions">
                    <a class="btn btn--primary" href="tel:8659646348">Call 865-964-6348</a>
                    <a class="btn btn--ghost" href="#services">Review Services</a>
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="container footer-grid">
            <div>
                <strong>Loudon Mechanical Services</strong>
                <p>HVAC, refrigeration, ice machines, restaurant equipment, and preventive maintenance.</p>
            </div>
            <div>
                <span>Call</span>
                <a href="tel:8659646348">865-964-6348</a>
            </div>
            <div>
                <span>Built under</span>
                <p>Volunteer Technology Systems</p>
            </div>
        </div>
    </footer>

    <a class="mobile-call" href="tel:8659646348">
        <span>Call LMS</span>
        <strong>865-964-6348</strong>
    </a>
</body>
</html>
