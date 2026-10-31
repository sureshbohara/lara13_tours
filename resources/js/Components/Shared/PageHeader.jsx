import React from 'react';
import { usePage } from '@inertiajs/react';

export default function PageHeader({ title, subtitle, bgImage }) {
    const { props } = usePage();
    const setting = props.setting || {};
    const defaultBg = setting.breadcrumb_url;
    const finalBg = bgImage || defaultBg;

    return (
        <section 
            className="listing-page-header" 
            style={{
                background: `linear-gradient(to right, rgba(15,26,46,0.9), rgba(15,26,46,0.7)), url('${finalBg}')`,
                backgroundSize: 'cover',
                backgroundPosition: 'center',
                padding: '200px 0 100px'
            }}
        >
            <div className="container text-center">
                <h1 style={{ color: 'white', fontSize: 'clamp(2rem, 4vw, 3rem)', marginBottom: subtitle ? '15px' : '0' }}>
                    {title}
                </h1>
                {subtitle && (
                    <p style={{ color: 'rgba(255,255,255,0.9)', fontSize: '1.1rem', maxWidth: '600px', margin: '0 auto' }}>
                        {subtitle}
                    </p>
                )}
            </div>
        </section>
    );
}