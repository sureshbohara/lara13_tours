import React, { useState } from 'react';
import { Head, usePage } from '@inertiajs/react';
import FrontLayout from '../Layouts/FrontLayout';
import PageHeader from '../Components/Shared/PageHeader';
export default function Faqs({ faqs }) {
    const { props } = usePage();
    const setting = props.setting || {};
    const breadcrumbImage = setting.breadcrumb_url;

    const [openIndex, setOpenIndex] = useState(null);

    const toggleAccordion = (index) => {
        setOpenIndex(openIndex === index ? null : index);
    };

    return (
        <>
            <Head>
                <title>{`FAQs | ${setting.system_name || 'SP Travel and Tours'}`}</title>
                {setting.meta_description && <meta name="description" content={setting.meta_description} />}
                {setting.meta_keywords && <meta name="keywords" content={setting.meta_keywords} />}
            </Head>


            <PageHeader title="Frequently Asked Questions" subtitle="Find answers to the most common questions about our trips, bookings, and services." />

         
            <section className="section" style={{ background: 'var(--bg-soft)', padding: '25px 0' }}>
                <div className="container">
                    <div className="row justify-content-center">
                        <div className="col-lg-12">
                            <div className="details-card" style={{ padding: '20px' }}>
                                <div className="accordion accordion-itinerary" id="faqAccordion">
                                    {faqs && faqs.length > 0 ? (
                                        faqs.map((faq, index) => (
                                            <div className="accordion-item" key={faq.id || index}>
                                                <h2 className="accordion-header" id={`heading${index}`}>
                                                    <button 
                                                        className={`accordion-button ${openIndex === index ? '' : 'collapsed'}`} 
                                                        type="button" 
                                                        onClick={() => toggleAccordion(index)}
                                                        style={{ fontSize: '16px', fontWeight: '600' }}
                                                    >
                                                        {faq.question}
                                                    </button>
                                                </h2>
                                                {openIndex === index && (
                                                    <div id={`collapse${index}`} className="accordion-collapse show">
                                                        <div className="accordion-body" style={{ color: 'var(--text-muted)', lineHeight: '1.8' }}>
                                                            {faq.answer}
                                                        </div>
                                                    </div>
                                                )}
                                            </div>
                                        ))
                                    ) : (
                                        <div className="text-center py-5">
                                            <i className="bi bi-question-circle" style={{ fontSize: '40px', color: 'var(--text-muted)', opacity: 0.3 }}></i>
                                            <p style={{ marginTop: '20px', color: 'var(--text-muted)' }}>No FAQs available at the moment.</p>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

Faqs.layout = (page) => <FrontLayout>{page}</FrontLayout>;