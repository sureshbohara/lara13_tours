import React from 'react';
import { Head, Link, usePage, useForm } from '@inertiajs/react';
import { toast } from 'react-hot-toast';
import FrontLayout from '../Layouts/FrontLayout';
import PageHeader from '../Components/Shared/PageHeader';
export default function Contact() {
    const { props } = usePage();
    const setting = props.setting || {};

    const breadcrumbImage = setting.breadcrumb_url;

    const { data, setData, post, processing, errors, reset } = useForm({
        name: '', phone: '', email: '', subject: '', message: ''
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/contact-us', {
            preserveScroll: true,
            onSuccess: () => {
                reset();
                toast.success('Thank you! Your message has been sent successfully.');
            },
            onError: () => {
                toast.error('Please fix the errors in the form.');
            }
        });
    };

    return (
        <>
      
            <Head>
                <title>{`Contact Us | ${setting.system_name || 'SP Travel and Tours'}`}</title>
                {setting.meta_description && <meta name="description" content={setting.meta_description} />}
                {setting.meta_keywords && <meta name="keywords" content={setting.meta_keywords} />}
            </Head>

     
            <PageHeader title="Contact Us" subtitle="Reach out with any questions or feedback. We'll respond promptly." />

            {/* ================= CONTACT INFO & FORM ================= */}
            <section className="section" style={{ background: 'var(--bg-soft)', padding: '60px 0' }}>
                <div className="container">
                    <div className="row g-4">
                        
                      
                        <div className="col-lg-4" style={{ height: '100%', display: 'flex', flexDirection: 'column' }}>
                            <div style={{ 
                                background: 'var(--theme-primary)',
                                borderRadius: 'var(--radius)',
                                padding: '20px',
                                height: '100%',
                                display: 'flex',
                                flexDirection: 'column',
                                gap: '20px',
                                boxShadow: 'var(--shadow-md)'
                            }}>
                                
                                {/* Phone Card */}
                                <div style={{ padding: '25px', display: 'flex', alignItems: 'center', gap: '20px', background: 'var(--bg-white)', borderRadius: '8px', flex: '1' }}>
                                    <div style={{ width: '50px', height: '50px', background: 'rgba(212, 175, 106, 0.15)', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
                                        <i className="bi bi-telephone-fill" style={{ color: 'var(--theme-accent)', fontSize: '20px' }}></i>
                                    </div>
                                    <div>
                                        <h5 style={{ fontFamily: 'Poppins, sans-serif', fontSize: '14px', fontWeight: '700', color: 'var(--theme-primary)', margin: '0 0 5px 0', textTransform: 'uppercase' }}>Phone Number</h5>
                                        <a href={`tel:${setting.phone || '+9779849352533'}`} style={{ color: 'var(--text-muted)', fontSize: '14px', textDecoration: 'none' }}>
                                            {setting.phone || '+977 9849352533'}
                                        </a>
                                    </div>
                                </div>

                                {/* Email Card */}
                                <div style={{ padding: '25px', display: 'flex', alignItems: 'center', gap: '20px', background: 'var(--bg-white)', borderRadius: '8px', flex: '1' }}>
                                    <div style={{ width: '50px', height: '50px', background: 'rgba(212, 175, 106, 0.15)', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
                                        <i className="bi bi-envelope-fill" style={{ color: 'var(--theme-accent)', fontSize: '20px' }}></i>
                                    </div>
                                    <div>
                                        <h5 style={{ fontFamily: 'Poppins, sans-serif', fontSize: '14px', fontWeight: '700', color: 'var(--theme-primary)', margin: '0 0 5px 0', textTransform: 'uppercase' }}>Email Address</h5>
                                        <a href={`mailto:${setting.email || 'info@sptravel.com'}`} style={{ color: 'var(--text-muted)', fontSize: '14px', textDecoration: 'none' }}>
                                            {setting.email || 'info@sptravel.com'}
                                        </a>
                                    </div>
                                </div>

                                {/* Address Card */}
                                <div style={{ padding: '25px', display: 'flex', alignItems: 'center', gap: '20px', background: 'var(--bg-white)', borderRadius: '8px', flex: '1' }}>
                                    <div style={{ width: '50px', height: '50px', background: 'rgba(212, 175, 106, 0.15)', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
                                        <i className="bi bi-geo-alt-fill" style={{ color: 'var(--theme-accent)', fontSize: '20px' }}></i>
                                    </div>
                                    <div>
                                        <h5 style={{ fontFamily: 'Poppins, sans-serif', fontSize: '14px', fontWeight: '700', color: 'var(--theme-primary)', margin: '0 0 5px 0', textTransform: 'uppercase' }}>Our Address</h5>
                                        <p style={{ color: 'var(--text-muted)', fontSize: '14px', margin: 0, lineHeight: '1.5' }}>
                                            {setting.address || 'Bansbari Chowk, Nagarjun, Kathmandu, Nepal'}
                                        </p>
                                    </div>
                                </div>

                                {/* Work Hours Card */}
                                <div style={{ padding: '25px', display: 'flex', alignItems: 'center', gap: '20px', background: 'var(--bg-white)', borderRadius: '8px', flex: '1' }}>
                                    <div style={{ width: '50px', height: '50px', background: 'rgba(212, 175, 106, 0.15)', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
                                        <i className="bi bi-clock-fill" style={{ color: 'var(--theme-accent)', fontSize: '20px' }}></i>
                                    </div>
                                    <div>
                                        <h5 style={{ fontFamily: 'Poppins, sans-serif', fontSize: '14px', fontWeight: '700', color: 'var(--theme-primary)', margin: '0 0 5px 0', textTransform: 'uppercase' }}>Work Hours</h5>
                                        <p style={{ color: 'var(--text-muted)', fontSize: '14px', margin: 0, lineHeight: '1.5' }}>
                                            Mon-Fri: 9:00 AM - 6:00 PM<br/>Sat: 10:00 AM - 4:00 PM
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>

                    
                        <div className="col-lg-8">
                            <div className="details-card" style={{ padding: '25px', height: '100%', display: 'flex', flexDirection: 'column' }}>
                                <h2 style={{ fontFamily: 'Playfair Display, serif', fontSize: '28px', fontWeight: '700', color: 'var(--theme-primary)', marginBottom: '10px' }}>
                                    Get In Touch
                                </h2>
                                <p style={{ color: 'var(--text-muted)', marginBottom: '30px', fontSize: '14px' }}>
                                    Fill out the form below and we will get back to you.
                                </p>

                                <form onSubmit={handleSubmit} style={{ flex: 1, display: 'flex', flexDirection: 'column', justifyContent: 'center' }}>
                                    <div className="row g-3">

                                        <div className="col-md-6">
                                            <label className="form-label" style={{ fontSize: '13px', fontWeight: '600', color: 'var(--theme-primary)' }}>Full Name <span style={{ color: 'red' }}>*</span></label>
                                            <input type="text" className={`form-control ${errors.name ? 'is-invalid' : ''}`} value={data.name} onChange={(e) => setData('name', e.target.value)} placeholder="John Doe" required style={{ padding: '12px 15px', borderRadius: '8px' }} />
                                            {errors.name && <div className="invalid-feedback">{errors.name}</div>}
                                        </div>

                                        <div className="col-md-6">
                                            <label className="form-label" style={{ fontSize: '13px', fontWeight: '600', color: 'var(--theme-primary)' }}>Phone Number</label>
                                            <input type="text" className={`form-control ${errors.phone ? 'is-invalid' : ''}`} value={data.phone} onChange={(e) => setData('phone', e.target.value)} placeholder="(123) 456-7890" style={{ padding: '12px 15px', borderRadius: '8px' }} />
                                            {errors.phone && <div className="invalid-feedback">{errors.phone}</div>}
                                        </div>

                                        <div className="col-6">
                                            <label className="form-label" style={{ fontSize: '13px', fontWeight: '600', color: 'var(--theme-primary)' }}>Email Address <span style={{ color: 'red' }}>*</span></label>
                                            <input type="email" className={`form-control ${errors.email ? 'is-invalid' : ''}`} value={data.email} onChange={(e) => setData('email', e.target.value)} placeholder="name@example.com" required style={{ padding: '12px 15px', borderRadius: '8px' }} />
                                            {errors.email && <div className="invalid-feedback">{errors.email}</div>}
                                        </div>

                                        <div className="col-6">
                                            <label className="form-label" style={{ fontSize: '13px', fontWeight: '600', color: 'var(--theme-primary)' }}>Subject</label>
                                            <input type="text" className={`form-control ${errors.subject ? 'is-invalid' : ''}`} value={data.subject} onChange={(e) => setData('subject', e.target.value)} placeholder="How can we help you?" style={{ padding: '12px 15px', borderRadius: '8px' }} />
                                            {errors.subject && <div className="invalid-feedback">{errors.subject}</div>}
                                        </div>

                                        <div className="col-12">
                                            <label className="form-label" style={{ fontSize: '13px', fontWeight: '600', color: 'var(--theme-primary)' }}>Message <span style={{ color: 'red' }}>*</span></label>
                                            <textarea className={`form-control ${errors.message ? 'is-invalid' : ''}`} value={data.message} onChange={(e) => setData('message', e.target.value)} rows="3" placeholder="Tell us about your travel plans..." required style={{ padding: '12px 15px', borderRadius: '8px', resize: 'vertical' }}></textarea>
                                            {errors.message && <div className="invalid-feedback">{errors.message}</div>}
                                        </div>

                                        <div className="col-12" style={{ marginTop: '10px' }}>
                                            <button type="submit" className="btn-solid" disabled={processing} style={{ padding: '14px 30px', fontSize: '14px' }}>
                                                {processing ? <><span className="spinner-border spinner-border-sm me-2"></span> Sending...</> : 'Send Message'}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

         
            <section className="section" style={{ background: 'var(--bg-white)', padding: '25px 0' }}>
                <div className="container">
                    <div style={{ textAlign: 'center', marginBottom: '40px' }}>

                        <h2 style={{ fontFamily: 'Playfair Display, serif', fontSize: '32px', fontWeight: '700', color: 'var(--theme-primary)', margin: 0 }}>
                            Find Us on Map
                        </h2>
                    </div>

                    <div style={{ borderRadius: 'var(--radius)', overflow: 'hidden', boxShadow: 'var(--shadow-md)', border: '1px solid var(--border-color)' }}>
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3531.428098705093!2d85.3137!3d27.7172!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjfCsDQzJzAyLjAiTiA4NcKwMTgnNDkuMyJF!5e0!3m2!1sen!2snp!4v1234567890"
                            width="100%" height="450" style={{ border: 0 }} allowFullScreen="" loading="lazy" title="Our Location"
                        ></iframe>
                    </div>
                </div>
            </section>
        </>
    );
}

Contact.layout = (page) => <FrontLayout>{page}</FrontLayout>;