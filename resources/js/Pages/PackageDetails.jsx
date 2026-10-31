import React, { useState, useEffect } from 'react';
import { Head, Link, usePage, useForm } from '@inertiajs/react'; 
import { toast } from 'react-hot-toast'; 
import FrontLayout from '../Layouts/FrontLayout';


import BookingModal from '../Components/PackageDetails/BookingModal';
import PackageSidebar from '../Components/PackageDetails/PackageSidebar';
import PdfTemplate from '../Components/PackageDetails/PdfTemplate';

export default function PackageDetails({ package: pkg, fixedDepartures, relatedPackages, reviews }) {
    const { props } = usePage();
    const setting = props.setting || {};
    const reviewList = reviews || []; 

    const pageTitle = pkg?.name ? `${pkg.name} | ${setting.system_name || 'SP Travel and Tours'}` : setting.system_name || 'SP Travel and Tours';
    const metaDescription = pkg?.meta_description || setting.meta_description || 'Find the perfect trek, climb, or tour tailored to your dreams.';
    const metaKeywords = pkg?.meta_keywords || setting.meta_keywords || 'travel, nepal, trekking, tours';

    const heroImage = pkg?.feature_image_url || pkg?.image_url || 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w=1920&auto=format&fit=crop';

    const [openItinerary, setOpenItinerary] = useState(0);
    const [openFaq, setOpenFaq] = useState(0);
    const [activeSection, setActiveSection] = useState('highlights');
    const [showReviewForm, setShowReviewForm] = useState(false);
    const [showBookingForm, setShowBookingForm] = useState(false);

    const { data, setData, post, processing, errors, reset } = useForm({
        name: '', email: '', address: '', rating: 5, review: ''
    });

    const submitReview = (e) => {
        e.preventDefault();
        post(`/tour/${pkg.slug}/review`, {
            preserveScroll: true,
            onSuccess: () => {
                reset();
                setShowReviewForm(false);
                toast.success('Thank you! Your review has been submitted successfully.'); 
            },
            onError: () => toast.error('Please fix the errors in the form.')
        });
    };

    useEffect(() => {
        const handleScroll = () => {
            const sections = ['highlights', 'overview', 'itinerary', 'included-excluded', 'equipment', 'faqs', 'gallery', 'reviews'];
            let current = 'highlights';
            sections.forEach(section => {
                const element = document.getElementById(section);
                if (element && element.getBoundingClientRect().top <= 150) current = section;
            });
            setActiveSection(current);
        };
        window.addEventListener('scroll', handleScroll);
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    const scrollToSection = (id) => {
        const element = document.getElementById(id);
        if (element) window.scrollTo({ top: element.offsetTop - 100, behavior: 'smooth' });
    };

    const equipmentCategories = [
        { label: 'General', icon: '🧳', data: pkg?.general },
        { label: 'Lower Body', icon: '👖', data: pkg?.lower_body },
        { label: 'Upper Body', icon: '🧥', data: pkg?.upper_body },
        { label: 'Footwear', icon: '👟', data: pkg?.footwear },
        { label: 'Accessories', icon: '🎒', data: pkg?.accessories },
    ];

    return (
        <>
            <Head title={pageTitle}>
                <meta name="description" content={metaDescription} />
                <meta name="keywords" content={metaKeywords} />
            </Head>

            <section className="listing-page-header" style={{
                background: `linear-gradient(to right, rgba(15,26,46,0.9), rgba(15,26,46,0.7)), url('${heroImage}')`,
                backgroundSize: 'cover', backgroundPosition: 'center', paddingBottom: '80px'
            }}>
                <div className="container">
                    <nav className="hidden-xs" aria-label="breadcrumb" style={{ marginBottom: '20px' }}>
                        <ol className="breadcrumb mb-0" style={{ background: 'transparent', justifyContent: 'center' }}>
                            {pkg?.categories?.map((cat, idx) => (
                                <li key={idx} className="breadcrumb-item">
                                    <Link href={`/packages/${cat.slug}`} style={{ color: 'var(--theme-accent)' }}> {cat.name} </Link>
                                </li>
                            ))}
                            <li className="breadcrumb-item active" style={{ color: 'white' }}> {pkg?.name} </li>
                        </ol>
                    </nav>
                    <h1 style={{ color: 'white', fontSize: 'clamp(1rem, 4vw, 3rem)', marginBottom: '15px' }}>{pkg?.name}</h1>
                </div>
            </section>

            <section className="inner_menu hidden-xs" id="single-content-navbar">
                <div className="container">
                    <nav className="navbar navbar-expand-lg">
                        <ul className="navbar-nav mobileDiv">
                            {[
                                { id: 'highlights', label: 'Highlights' },
                                { id: 'overview', label: 'Overview' },
                                { id: 'itinerary', label: 'Itinerary' },
                                { id: 'included-excluded', label: 'Included / Excluded' },
                                { id: 'equipment', label: 'Equipment' },
                                { id: 'faqs', label: 'FAQs' },
                                { id: 'gallery', label: 'Trip Gallery' },
                                { id: 'reviews', label: 'Reviews' }
                            ].map((item) => (
                                <li className="nav-item" key={item.id}>
                                    <a className={`nav-link scroll-link ${activeSection === item.id ? 'active' : ''}`} 
                                       href={`#${item.id}`} onClick={(e) => { e.preventDefault(); scrollToSection(item.id); }}>
                                         {item.label}
                                    </a>
                                </li>
                            ))}
                        </ul>
                    </nav>
                </div>
            </section>

            <section className="package_details">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-9">
                            <div id="highlights" className="page-scroll">
                                <div className="details-card">
                                    <p style={{ marginBottom: '25px', color: 'var(--text-muted)', lineHeight: 1.8 }}>
                                        {pkg?.excerpt || 'Embark on the adventure of a lifetime with our expertly crafted itinerary.'}
                                    </p>
                                </div>

                                <div className="details-card glance">
                                    <h4 style={{ fontFamily: 'Poppins, sans-serif', fontSize: '1.2rem', fontWeight: 700, color: 'var(--theme-primary)', marginBottom: '20px' }}>At a Glance</h4>
                                    <ul className="glance-grid mb-4">
                                        {pkg?.duration && <li className="item_list"><div className="icon"><i className="bi bi-clock-history"></i></div><div className="text"><span className="info-title">Duration</span><span className="info">{pkg.duration}</span></div></li>}
                                        {pkg?.transportation && <li className="item_list"><div className="icon"><i className="bi bi-car-front-fill"></i></div><div className="text"><span className="info-title">Transportation</span><span className="info">{pkg.transportation}</span></div></li>}
                                        {pkg?.trip_grading && <li className="item_list"><div className="icon"><i className="bi bi-bar-chart-line-fill"></i></div><div className="text"><span className="info-title">Trip Grading</span><span className="info">{pkg.trip_grading}</span></div></li>}
                                        {pkg?.max_altitude && <li className="item_list"><div className="icon"><i className="bi bi-compass-fill"></i></div><div className="text"><span className="info-title">Max. Elevation</span><span className="info">{pkg.max_altitude}</span></div></li>}
                                        {pkg?.accommodation && <li className="item_list"><div className="icon"><i className="bi bi-house-door-fill"></i></div><div className="text"><span className="info-title">Accommodation</span><span className="info">{pkg.accommodation}</span></div></li>}
                                        {pkg?.meals && <li className="item_list"><div className="icon"><i className="bi bi-egg-fried"></i></div><div className="text"><span className="info-title">Meals</span><span className="info">{pkg.meals}</span></div></li>}
                                        {pkg?.best_season && <li className="item_list"><div className="icon"><i className="bi bi-sun-fill"></i></div><div className="text"><span className="info-title">Best Season</span><span className="info">{pkg.best_season}</span></div></li>}
                                    </ul>
                                </div>

                                {pkg?.highlight_key && pkg.highlight_key.length > 0 && (
                                    <div className="details-card highlights">
                                        <div className="highlight_points">
                                            <h4 style={{ fontFamily: 'Poppins, sans-serif', fontSize: '1.1rem', fontWeight: 700, color: 'var(--bg-white)', marginBottom: '15px' }}>Highlights Point</h4>
                                            <ul className="list-unstyled mb-0">
                                                {pkg.highlight_key.map((point, idx) => (
                                                    <li key={idx} className="d-flex align-items-start mb-2" style={{ color: 'var(--bg-white)', fontSize: '0.95rem' }}>
                                                        <i className="bi bi-check-circle-fill highlight_points_icon me-2 mt-1"></i> {point}
                                                    </li>
                                                ))}
                                            </ul>
                                        </div>
                                    </div>
                                )}
                            </div>

                            <div id="overview" className="page-scroll">
                                <div className="details-card mb-4 mt-4">
                                    <h3 className="sub_title">Trip Overview</h3>
                                    <div className="overview_info" style={{ textAlign: 'justify', color: 'var(--text-muted)', lineHeight: 1.8 }} dangerouslySetInnerHTML={{ __html: pkg?.content || pkg?.description || 'No overview available.' }} />
                                </div>
                            </div>

                            <div id="itinerary" className="page-scroll mb-4">
                                <h3 className="sub_title" style={{ marginBottom: '25px' }}>Trip Itinerary</h3>
                                <div className="accordion accordion-itinerary" id="itineraryAccordion">
                                    {pkg?.itinerary_data?.map((day, index) => (
                                        <div className="accordion-item" key={index}>
                                            <h2 className="accordion-header" id={`heading${index}`}>
                                                <button className={`accordion-button ${openItinerary === index ? '' : 'collapsed'}`} type="button" onClick={() => setOpenItinerary(openItinerary === index ? -1 : index)}>
                                                    {day.name || `Day ${index + 1}`}
                                                </button>
                                            </h2>
                                            {openItinerary === index && (
                                                <div id={`collapse${index}`} className="accordion-collapse show">
                                                    <div className="accordion-body">
                                                        <p>{day.content}</p>
                                                        <div className="d-flex flex-wrap gap-3 mt-2" style={{ fontSize: '13px', color: 'var(--text-muted)' }}>
                                                            {day.max_elevation && <span><i className="bi bi-arrow-up"></i> {day.max_elevation}</span>}
                                                            {day.duration && <span><i className="bi bi-clock"></i> {day.duration}</span>}
                                                            {day.meals && <span><i className="bi bi-cup-hot"></i> {day.meals}</span>}
                                                            {day.accommodation && <span><i className="bi bi-house"></i> {day.accommodation}</span>}
                                                        </div>
                                                    </div>
                                                </div>
                                            )}
                                        </div>
                                    ))}
                                </div>
                            </div>

                            <div id="included-excluded" className="page-scroll">
                                <div className="details-card included-excluded mb-4">
                                    {pkg?.included_data && pkg.included_data.length > 0 && (
                                        <>
                                            <h3 className="sub_title">Included in Trip</h3>
                                            <ul className="list-group list-group-flush included mb-4">
                                                {pkg.included_data.map((item, idx) => (
                                                    <li key={idx} className="list-group-item">
                                                        <i className="bi bi-check-circle-fill text-success me-2"></i> {item.content}
                                                    </li>
                                                ))}
                                            </ul>
                                        </>
                                    )}
                                    {pkg?.excluded_data && pkg.excluded_data.length > 0 && (
                                        <>
                                            <h3 className="sub_title" style={{ marginTop: '10px' }}>Excluded in Trip</h3>
                                            <ul className="list-group list-group-flush excluded">
                                                {pkg.excluded_data.map((item, idx) => (
                                                    <li key={idx} className="list-group-item">
                                                        <i className="bi bi-x-circle-fill text-danger me-2"></i> {item.content}
                                                    </li>
                                                ))}
                                            </ul>
                                        </>
                                    )}
                                </div>
                            </div>

                            {equipmentCategories.some(cat => cat.data && cat.data.length > 0) && (
                                <div id="equipment" className="page-scroll">
                                    <div className="details-card equipment mb-4">
                                        <h3 className="sub_title">Trekking Equipment</h3>
                                        <p className="mb-4" style={{ color: 'rgba(255,255,255,0.8)' }}>Below is a recommended list of gear.</p>
                                        <div className="row">
                                            {equipmentCategories.map((cat, catIdx) => (
                                                cat.data && cat.data.length > 0 && (
                                                    <div className="col-md-12 mb-4" key={catIdx}>
                                                        <h4 style={{ fontFamily: 'Poppins, sans-serif', fontSize: '1.1rem', fontWeight: 700, color: 'var(--theme-accent)', marginBottom: '15px', paddingBottom: '10px', borderBottom: '1px dashed rgba(255,255,255,0.2)' }}>
                                                            <span className="me-2">{cat.icon}</span> {cat.label}
                                                        </h4>
                                                        <ul className="products_list list-unstyled">
                                                            {cat.data.map((item, idx) => (
                                                                <li key={idx} className="d-flex align-items-start mb-2" style={{ color: 'rgba(255,255,255,0.9)', fontSize: '0.95rem' }}>
                                                                    <i className="bi bi-check-circle-fill text-success me-2 mt-1"></i> {item.content}
                                                                </li>
                                                            ))}
                                                        </ul>
                                                    </div>
                                                )
                                            ))}
                                        </div>
                                    </div>
                                </div>
                            )}

                            {pkg?.faqs && Array.isArray(pkg.faqs) && pkg.faqs.length > 0 && (
                                <div id="faqs" className="page-scroll">
                                    <div className="details-card mb-4">
                                        <h3 className="sub_title">Trip FAQs</h3>
                                        <div className="accordion accordion-itinerary" id="faqAccordion">
                                            {pkg.faqs.map((faq, index) => (
                                                <div className="accordion-item" key={index}>
                                                    <h2 className="accordion-header" id={`faqHeading${index}`}>
                                                        <button className={`accordion-button ${openFaq === index ? '' : 'collapsed'}`} type="button" onClick={() => setOpenFaq(openFaq === index ? -1 : index)}>
                                                            {faq.label || faq.question}
                                                        </button>
                                                    </h2>
                                                    {openFaq === index && (
                                                        <div id={`faqCollapse${index}`} className="accordion-collapse show">
                                                            <div className="accordion-body">{faq.detail || faq.answer}</div>
                                                        </div>
                                                    )}
                                                </div>
                                            ))}
                                        </div>
                                    </div>
                                </div>
                            )}

                            {pkg?.gallery && pkg.gallery.length > 0 && (
                                <div id="gallery" className="page-scroll">
                                    <div className="details-card mb-5">
                                        <h3 className="sub_title">Travel Gallery</h3>
                                        <div className="row g-3">
                                            {pkg.gallery.slice(0, 6).map((img, idx) => (
                                                <div className="col-md-4 col-sm-6" key={idx}>
                                                    <a href={`/images/${img}`} className="gallery-item" target="_blank" rel="noopener noreferrer">
                                                        <div className="img-wrapper">
                                                            <img src={`/images/${img}`} alt={`Gallery ${idx + 1}`} className="img-fluid" />
                                                        </div>
                                                    </a>
                                                </div>
                                            ))}
                                        </div>
                                    </div>
                                </div>
                            )}

                            <div id="reviews" className="page-scroll">
                                <div className="d-flex justify-content-between align-items-center mb-4">
                                    <h3 className="sub_title mb-0">Traveler Reviews ({reviewList.length})</h3>
                                    <button className="btn btn-solid-sm" onClick={() => setShowReviewForm(!showReviewForm)}>
                                        <i className="bi bi-pencil-square me-2"></i>Write a Review
                                    </button>
                                </div>

                                {showReviewForm && (
                                    <div className="review-form-card mb-4">
                                        <h5 className="mb-3">Share Your Experience</h5>
                                        <form onSubmit={submitReview}>
                                            <div className="row g-3">
                                                <div className="col-md-6">
                                                    <label className="form-label small">Your Name</label>
                                                    <input type="text" className={`form-control ${errors.name ? 'is-invalid' : ''}`} value={data.name} onChange={e => setData('name', e.target.value)} placeholder="John Doe" required />
                                                    {errors.name && <div className="invalid-feedback">{errors.name}</div>}
                                                </div>
                                                <div className="col-md-6">
                                                    <label className="form-label small">Your Email</label>
                                                    <input type="email" className={`form-control ${errors.email ? 'is-invalid' : ''}`} value={data.email} onChange={e => setData('email', e.target.value)} placeholder="john@example.com" required />
                                                    {errors.email && <div className="invalid-feedback">{errors.email}</div>}
                                                </div>
                                                <div className="col-12">
                                                    <label className="form-label small">Your Location (Optional)</label>
                                                    <input type="text" className="form-control" value={data.address} onChange={e => setData('address', e.target.value)} placeholder="e.g., London, UK" />
                                                </div>
                                                <div className="col-12">
                                                    <label className="form-label small">Rating</label>
                                                    <select className="form-select" value={data.rating} onChange={e => setData('rating', e.target.value)} required>
                                                        <option value="5">★★★★★ (5 Stars)</option>
                                                        <option value="4">★★★★☆ (4 Stars)</option>
                                                        <option value="3">★★★☆☆ (3 Stars)</option>
                                                    </select>
                                                </div>
                                                <div className="col-12">
                                                    <label className="form-label small">Your Review</label>
                                                    <textarea className={`form-control ${errors.review ? 'is-invalid' : ''}`} rows="4" value={data.review} onChange={e => setData('review', e.target.value)} placeholder="Tell us about your experience..." required></textarea>
                                                    {errors.review && <div className="invalid-feedback">{errors.review}</div>}
                                                </div>
                                                <div className="col-12 text-end">
                                                    <button type="button" className="btn btn-secondary me-2" onClick={() => setShowReviewForm(false)}>Cancel</button>
                                                    <button type="submit" className="btn btn-success" disabled={processing}>
                                                        {processing ? 'Submitting...' : 'Submit Review'}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                )}

                                <div className="reviews-list">
                                    {reviewList.length > 0 ? reviewList.map((rev, idx) => (
                                        <div key={idx} className="review-card">
                                            <div className="review-header d-flex justify-content-between align-items-start mb-2">
                                                <div className="d-flex align-items-center gap-3">
                                                    <div className="review-avatar">{rev.name.charAt(0).toUpperCase()}</div>
                                                    <div>
                                                        <h6 className="reviewer-name mb-0">{rev.name}</h6>
                                                        <small className="text-muted">{rev.address || 'Verified Traveler'}</small>
                                                    </div>
                                                </div>
                                                <div className="review-stars">
                                                    {'★'.repeat(rev.rating)}{'☆'.repeat(5 - rev.rating)}
                                                </div>
                                            </div>
                                            <p className="review-text mb-0">"{rev.review}"</p>
                                        </div>
                                    )) : (
                                        <div className="text-center py-5 text-muted details-card">
                                            <i className="bi bi-chat-square-text" style={{ fontSize: '3rem', opacity: 0.3 }}></i>
                                            <p className="mt-3">No reviews yet. Be the first to share your experience!</p>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>

                        <PackageSidebar 
                            pkg={pkg} 
                            setting={setting} 
                            onBookClick={() => setShowBookingForm(true)} 
                        />
                    </div>
                </div>
            </section>

            <BookingModal 
                pkg={pkg} 
                show={showBookingForm} 
                onClose={() => setShowBookingForm(false)} 
            />

         
            <PdfTemplate 
                pkg={pkg} 
                setting={setting} 
                equipmentCategories={equipmentCategories} 
            />
        </>
    );
}

PackageDetails.layout = (page) => <FrontLayout>{page}</FrontLayout>;