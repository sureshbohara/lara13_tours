import React from 'react';
import { Head, usePage } from '@inertiajs/react';
import FrontLayout from '../Layouts/FrontLayout';
import PageHeader from '../Components/Shared/PageHeader';
export default function About() {
    const { props } = usePage();
    const setting = props.setting || {};
    
    const breadcrumbImage = setting.breadcrumb_url;
    const aboutImage = setting.image1_url;
    const infoText = setting.info1 || 'Your Gateway to Authentic Nepali Hospitality';

    return (
        <>
            <Head>
                <title>{`About Us | ${setting.system_name || 'SP Travel and Tours'}`}</title>
                {setting.meta_description && <meta name="description" content={setting.meta_description} />}
                {setting.meta_keywords && <meta name="keywords" content={setting.meta_keywords} />}
            </Head>

          
            <PageHeader title="About Us" subtitle="Discover our story, mission, and the passion behind every journey we create." />

            
            <section className="section" style={{ background: 'var(--bg-white)', padding: '80px 0' }}>
                <div className="container">
                    
              
                    <div className="row align-items-center g-5 mb-5">
                        
                     
                        <div className="col-lg-6">
                            <span style={{ 
                                color: 'var(--theme-accent)', 
                                fontWeight: '700', 
                                textTransform: 'uppercase', 
                                letterSpacing: '2px', 
                                fontSize: '14px',
                                marginBottom: '10px',
                                display: 'block'
                            }}>
                                Who We Are
                            </span>
                            
                            <h2 style={{ 
                                fontFamily: 'Playfair Display, serif', 
                                fontSize: 'clamp(2rem, 3vw, 2.5rem)', 
                                fontWeight: '700', 
                                color: 'var(--theme-primary)', 
                                marginBottom: '20px',
                                lineHeight: '1.2'
                            }}>
                                {setting.system_name || 'Your Trusted Travel Partner'}
                            </h2>
                            
                            <div 
                                className="info-content" 
                                style={{ color: 'var(--text-muted)', lineHeight: '1.8', fontSize: '1.05rem' }}
                                dangerouslySetInnerHTML={{ __html: infoText }} 
                            />
                        </div>

                      
                        <div className="col-lg-6">
                            <div style={{ position: 'relative' }}>
                                <img 
                                    src={aboutImage} 
                                    alt="About Us"
                                    style={{ 
                                        width: '100%', 
                                        boxShadow: 'var(--shadow-md)',
                                        objectFit: 'cover',
                                        maxHeight: '500px'
                                    }}
                                />
                                <div style={{
                                    position: 'absolute',
                                    bottom: '-20px',
                                    left: '-20px',
                                    background: 'var(--theme-primary)',
                                    color: 'white',
                                    padding: '20px 30px',
                                    borderRadius: 'var(--radius)',
                                    boxShadow: '0 10px 30px rgba(26, 43, 76, 0.3)',
                                    display: 'flex',
                                    alignItems: 'center',
                                    gap: '15px'
                                }}>
                                    <div style={{ fontSize: '36px', fontWeight: '800', color: 'var(--theme-accent)', lineHeight: '1' }}>15+</div>
                                    <div style={{ fontSize: '14px', lineHeight: '1.3', fontWeight: '500' }}>Years of<br/>Excellence</div>
                                </div>
                            </div>
                        </div>
                    </div>

                  
                    <div className="row g-4">
                        
                      
                        <div className="col-lg-4 col-md-6">
                            <div className="h-100 p-4 rounded-3" style={{ background: 'var(--bg-soft)', borderLeft: '4px solid var(--theme-accent)' }}>
                                <div className="d-flex align-items-center mb-3">
                                    <div className="flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle" style={{ width: '45px', height: '45px', background: 'rgba(212, 175, 106, 0.15)' }}>
                                        <i className="bi bi-bullseye" style={{ color: 'var(--theme-accent)', fontSize: '20px' }}></i>
                                    </div>
                                    <h5 className="mb-0 ms-3" style={{ fontFamily: 'Poppins, sans-serif', fontWeight: '700', color: 'var(--theme-primary)', fontSize: '18px' }}>Our Mission</h5>
                                </div>
                                <p className="mb-0" style={{ fontSize: '14px', color: 'var(--text-muted)', lineHeight: '1.6' }}>
                                    {setting.info2 || 'To provide sustainable, safe, and culturally immersive travel experiences that empower local communities.'}
                                </p>
                            </div>
                        </div>

                       
                        <div className="col-lg-4 col-md-6">
                            <div className="h-100 p-4 rounded-3" style={{ background: 'var(--bg-soft)', borderLeft: '4px solid var(--theme-nature)' }}>
                                <div className="d-flex align-items-center mb-3">
                                    <div className="flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle" style={{ width: '45px', height: '45px', background: 'rgba(45, 106, 79, 0.15)' }}>
                                        <i className="bi bi-eye" style={{ color: 'var(--theme-nature)', fontSize: '20px' }}></i>
                                    </div>
                                    <h5 className="mb-0 ms-3" style={{ fontFamily: 'Poppins, sans-serif', fontWeight: '700', color: 'var(--theme-primary)', fontSize: '18px' }}>Our Vision</h5>
                                </div>
                                <p className="mb-0" style={{ fontSize: '14px', color: 'var(--text-muted)', lineHeight: '1.6' }}>
                                    {setting.info3 || 'To be the most trusted and innovative travel company in Nepal, setting global standards in hospitality.'}
                                </p>
                            </div>
                        </div>

                   
                        <div className="col-lg-4 col-md-12">
                            <div className="h-100 p-4 rounded-3" style={{ background: 'var(--bg-soft)', borderLeft: '4px solid var(--theme-primary)' }}>
                                <div className="d-flex align-items-center mb-3">
                                    <div className="flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle" style={{ width: '45px', height: '45px', background: 'rgba(26, 43, 76, 0.1)' }}>
                                        <i className="bi bi-trophy" style={{ color: 'var(--theme-primary)', fontSize: '20px' }}></i>
                                    </div>
                                    <h5 className="mb-0 ms-3" style={{ fontFamily: 'Poppins, sans-serif', fontWeight: '700', color: 'var(--theme-primary)', fontSize: '18px' }}>Our Primary Goal</h5>
                                </div>
                                <p className="mb-0" style={{ fontSize: '14px', color: 'var(--text-muted)', lineHeight: '1.6' }}>
                                    {setting.info4 || 'To deliver exceptional, safe, and memorable travel experiences that exceed our guests\' expectations while promoting sustainable tourism.'}
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </>
    );
}

About.layout = (page) => <FrontLayout>{page}</FrontLayout>;