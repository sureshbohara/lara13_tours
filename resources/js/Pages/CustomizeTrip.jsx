import React from 'react';
import { Head, usePage, useForm } from '@inertiajs/react';
import { toast } from 'react-hot-toast';
import FrontLayout from '../Layouts/FrontLayout';
import PageHeader from '../Components/Shared/PageHeader';
export default function CustomizeTrip({ packages }) {
    const { props } = usePage();
    const setting = props.setting || {};
    const breadcrumbImage = setting.breadcrumb_url;

    const { data, setData, post, processing, errors, reset } = useForm({
        name: '', email: '', phone: '', address: '', destination: '', 
        arrival_date: '', departure_date: '', travelers: '', budget: '', message: ''
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/customize-trip', {
            preserveScroll: true,
            onSuccess: () => {
                reset();
                toast.success('Request sent successfully! We will contact you soon.');
            },
            onError: () => {
                toast.error('Please fix the errors in the form.');
            }
        });
    };

    return (
        <>
            <Head>
                <title>{`Customize Your Trip | ${setting.system_name || 'SP Travel and Tours'}`}</title>
            </Head>

             <PageHeader title="Customize Your Trip" />

            <section className="section" style={{ background: 'var(--bg-soft)', padding: '40px 0' }}>
                <div className="container">
                    <div className="row justify-content-center">
                        <div className="col-lg-10">
                            <div className="details-card" style={{ padding: '30px' }}>
                                
                                <div style={{ textAlign: 'center', marginBottom: '30px' }}>
                                    <h2 style={{ fontFamily: 'Playfair Display, serif', fontSize: '28px', fontWeight: '700', color: 'var(--theme-primary)', marginBottom: '15px' }}>
                                        We can’t wait to hear from you!
                                    </h2>
                                    <p style={{ color: 'var(--text-muted)', fontSize: '15px', lineHeight: '1.7' }}>
                                        Please complete the form below to customize your trip. Whether you have questions about our packages, need travel recommendations, or have specific requests, we're here to help!
                                    </p>
                                </div>

                                <form onSubmit={handleSubmit}>
                                    <div className="row g-3">
                                        <div className="col-md-6">
                                            <label className="form-label" style={{ fontSize: '13px', fontWeight: '600', color: 'var(--theme-primary)' }}>Name <span style={{ color: 'red' }}>*</span></label>
                                            <input type="text" className={`form-control ${errors.name ? 'is-invalid' : ''}`} value={data.name} onChange={(e) => setData('name', e.target.value)} placeholder="Enter full name" required style={{ padding: '12px 15px', borderRadius: '8px' }} />
                                            {errors.name && <div className="invalid-feedback">{errors.name}</div>}
                                        </div>

                                        <div className="col-md-6">
                                            <label className="form-label" style={{ fontSize: '13px', fontWeight: '600', color: 'var(--theme-primary)' }}>Email <span style={{ color: 'red' }}>*</span></label>
                                            <input type="email" className={`form-control ${errors.email ? 'is-invalid' : ''}`} value={data.email} onChange={(e) => setData('email', e.target.value)} placeholder="abc@xyz.com" required style={{ padding: '12px 15px', borderRadius: '8px' }} />
                                            {errors.email && <div className="invalid-feedback">{errors.email}</div>}
                                        </div>

                                        <div className="col-md-6">
                                            <label className="form-label" style={{ fontSize: '13px', fontWeight: '600', color: 'var(--theme-primary)' }}>Phone Number <span style={{ color: 'red' }}>*</span></label>
                                            <input type="text" className={`form-control ${errors.phone ? 'is-invalid' : ''}`} value={data.phone} onChange={(e) => setData('phone', e.target.value)} placeholder="XXXX-XXXXXX" required style={{ padding: '12px 15px', borderRadius: '8px' }} />
                                            {errors.phone && <div className="invalid-feedback">{errors.phone}</div>}
                                        </div>

                                        <div className="col-md-6">
                                            <label className="form-label" style={{ fontSize: '13px', fontWeight: '600', color: 'var(--theme-primary)' }}>Address</label>
                                            <input type="text" className={`form-control ${errors.address ? 'is-invalid' : ''}`} value={data.address} onChange={(e) => setData('address', e.target.value)} placeholder="Enter your address" style={{ padding: '12px 15px', borderRadius: '8px' }} />
                                            {errors.address && <div className="invalid-feedback">{errors.address}</div>}
                                        </div>

                                     

                                        <div className="col-md-4">
                                            <label className="form-label" style={{ fontSize: '13px', fontWeight: '600', color: 'var(--theme-primary)' }}>Arrival Date</label>
                                            <input type="date" className={`form-control ${errors.arrival_date ? 'is-invalid' : ''}`} value={data.arrival_date} onChange={(e) => setData('arrival_date', e.target.value)} style={{ padding: '12px 15px', borderRadius: '8px' }} />
                                            {errors.arrival_date && <div className="invalid-feedback">{errors.arrival_date}</div>}
                                        </div>

                                        <div className="col-md-4">
                                            <label className="form-label" style={{ fontSize: '13px', fontWeight: '600', color: 'var(--theme-primary)' }}>Departure Date</label>
                                            <input type="date" className={`form-control ${errors.departure_date ? 'is-invalid' : ''}`} value={data.departure_date} onChange={(e) => setData('departure_date', e.target.value)} style={{ padding: '12px 15px', borderRadius: '8px' }} />
                                            {errors.departure_date && <div className="invalid-feedback">{errors.departure_date}</div>}
                                        </div>

                                        <div className="col-md-4">
                                            <label className="form-label" style={{ fontSize: '13px', fontWeight: '600', color: 'var(--theme-primary)' }}>Number of Travelers</label>
                                            <input type="text" className={`form-control ${errors.travelers ? 'is-invalid' : ''}`} value={data.travelers} onChange={(e) => setData('travelers', e.target.value)} placeholder="Enter number of travelers" style={{ padding: '12px 15px', borderRadius: '8px' }} />
                                            {errors.travelers && <div className="invalid-feedback">{errors.travelers}</div>}
                                        </div>


                                           <div className="col-md-6">
                                            <label className="form-label" style={{ fontSize: '13px', fontWeight: '600', color: 'var(--theme-primary)' }}>Preferred Destination</label>
                                            <select className={`form-select ${errors.destination ? 'is-invalid' : ''}`} value={data.destination} onChange={(e) => setData('destination', e.target.value)} style={{ padding: '12px 15px', borderRadius: '8px' }}>
                                                <option value="">---Select Tour Package---</option>
                                                {packages && packages.map((pkg) => (
                                                    <option key={pkg.id} value={pkg.name}>{pkg.name}</option>
                                                ))}
                                                <option value="Other / Not Sure Yet">Other / Not Sure Yet</option>
                                            </select>
                                            {errors.destination && <div className="invalid-feedback">{errors.destination}</div>}
                                        </div>

                                        <div className="col-md-6">
                                            <label className="form-label" style={{ fontSize: '13px', fontWeight: '600', color: 'var(--theme-primary)' }}>Your Budget</label>
                                            <input type="text" className={`form-control ${errors.budget ? 'is-invalid' : ''}`} value={data.budget} onChange={(e) => setData('budget', e.target.value)} placeholder="Enter your budget (e.g., $1000 - $1500)" style={{ padding: '12px 15px', borderRadius: '8px' }} />
                                            {errors.budget && <div className="invalid-feedback">{errors.budget}</div>}
                                        </div>

                                        <div className="col-12">
                                            <label className="form-label" style={{ fontSize: '13px', fontWeight: '600', color: 'var(--theme-primary)' }}>Additional Requests or Questions <span style={{ color: 'red' }}>*</span></label>
                                            <textarea className={`form-control ${errors.message ? 'is-invalid' : ''}`} value={data.message} onChange={(e) => setData('message', e.target.value)} rows="5" placeholder="Tell us about your specific requests, dietary needs, or any questions..." required style={{ padding: '12px 15px', borderRadius: '8px', resize: 'vertical' }}></textarea>
                                            {errors.message && <div className="invalid-feedback">{errors.message}</div>}
                                        </div>

                                        <div className="col-12" style={{ marginTop: '10px' }}>
                                            <button type="submit" className="btn-solid" disabled={processing} style={{ padding: '14px 30px', fontSize: '15px', fontWeight: '700' }}>
                                                {processing ? <><span className="spinner-border spinner-border-sm me-2"></span> Sending...</> : 'Send Customize Request'}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

CustomizeTrip.layout = (page) => <FrontLayout>{page}</FrontLayout>;