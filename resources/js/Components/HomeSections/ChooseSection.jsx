import React from 'react';
import { usePage } from '@inertiajs/react';

export default function ChooseSection() {
    const { props } = usePage();
    const setting = props.setting || {};
    
    const bgImageUrl = setting.bg_image_url || '/default/noimage.png';
    const workTitle = setting.work_title || 'Why Choose SP Travel?';
    const workSubtitle = setting.work_sub_title || 'From your first trek to a full expedition, we ensure everything is perfect.';
    const workItems = setting.work_item || [];

    if (!workItems || workItems.length === 0) {
        return null;
    }

    return (
        <section className="choose-section section">
            <div className="container-fluid p-0">
                <div className="choose-wrapper">
                    <div className="choose-left">
                        <img src={bgImageUrl} alt="Mountain Adventure" className="choose-image" />
                    </div>
                    <div className="choose-right">
                        <div className="choose-content">
                            <h2 className="choose-title">{workTitle}</h2>
                            <p style={{ color: 'rgba(255,255,255,0.8)', marginBottom: '40px', fontSize: '16px' }}>
                                {workSubtitle}
                            </p>
                            <div className="choose-features">
                                {workItems.map((item, index) => (
                                    <div className="choose-feature" key={index}>
                                        <div className="feature-icon">
                                            <i className={item.icon}></i>
                                        </div>
                                        <div className="feature-content">
                                            <h4>{item.title}</h4>
                                            <p>{item.content}</p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}