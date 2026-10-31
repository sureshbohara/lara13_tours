import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function ContentSection() {
    const { props } = usePage();
    const setting = props.setting || {};
    const processItems = setting.process_item || []; 
    const infoText = setting.info1 || 'Your Gateway to Authentic Nepali Hospitality';

    if (!processItems || processItems.length === 0) {
        return null;
    }

    return (
        <section className="content-section section">
            <div className="container">
                <div className="row align-items-center">
                    <div className="col-lg-7 mb-4 mb-lg-0 hidden-xs">
                        <h2>We Create Unforgettable Travel Experiences</h2>
                        <div className="info-content" dangerouslySetInnerHTML={{ __html: infoText }} />
                    </div>

                    <div className="col-lg-5">
                        <div className="info-grid">
                            {processItems.map((item, index) => (
                                <div className="info-item" key={index}>
                                    <div className="info-icon">
                                        <i className={item.icon}></i>
                                    </div>
                                    <div className="info-text">
                                        <h4>{item.title}</h4>
                                        <p>{item.content}</p>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}