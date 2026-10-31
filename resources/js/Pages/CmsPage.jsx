import React from 'react';
import { Head, usePage } from '@inertiajs/react';
import FrontLayout from '../Layouts/FrontLayout';
import PageHeader from '../Components/Shared/PageHeader';
export default function CmsPage({ page }) {
    const { props } = usePage();
    const setting = props.setting || {};
    const breadcrumbImage = setting.breadcrumb_url;

    return (
        <>
            <Head>
                <title>{page.meta_title || `${page.title} | ${setting.system_name || 'SP Travel and Tours'}`}</title>
                {page.meta_description && <meta name="description" content={page.meta_description} />}
                {page.meta_keywords && <meta name="keywords" content={page.meta_keywords} />}
            </Head>

            <PageHeader title={page.title} />

       
            <section className="section" style={{ background: 'var(--bg-white)', padding: '40px 0' }}>
                <div className="container">
                    <div className="row justify-content-center">
                        <div className="col-lg-12">
                            <div className="details-card" style={{ padding: '30px' }}>
                                
                  
                                {page.short_content && (
                                    <p className="lead" style={{ 
                                        color: 'var(--text-muted)', 
                                        fontSize: '1.1rem', 
                                        marginBottom: '30px', 
                                        borderLeft: '4px solid var(--theme-accent)', 
                                        paddingLeft: '20px',
                                        fontStyle: 'italic'
                                    }}>
                                        {page.short_content}
                                    </p>
                                )}

                 
                                <div 
                                    className="cms-content" 
                                    style={{ 
                                        color: 'var(--text-main)', 
                                        lineHeight: '1.8',
                                        fontSize: '16px'
                                    }}
                                    dangerouslySetInnerHTML={{ __html: page.content }} 
                                />
                                
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

CmsPage.layout = (page) => <FrontLayout>{page}</FrontLayout>;