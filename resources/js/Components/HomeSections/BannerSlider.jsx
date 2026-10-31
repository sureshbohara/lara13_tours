import React from 'react';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay, EffectFade } from 'swiper/modules';
import { Link } from '@inertiajs/react';

import 'swiper/css';
import 'swiper/css/effect-fade';

export default function BannerSlider({ banners }) {
    if (!banners || banners.length === 0) {
        return null;
    }

    return (
        <section className="banner-slider-section">
            <Swiper
                modules={[Autoplay, EffectFade]}
                effect="fade"
                loop={banners.length > 1}
                autoplay={{ delay: 6000, disableOnInteraction: false }}
                className="h-full w-full"
            >
                {banners.map((banner) => (
                    <SwiperSlide key={banner.id}>
                        <div 
                            className="slide-item" 
                            style={{ backgroundImage: `url('${banner.image_url}')` }}
                        >
                            <div className="slide-content">
                                <h1>{banner.title}</h1>  

                                {banner.description && (
                                    <p  style={{ marginTop: '10px', fontSize: '1rem', opacity: 0.9 }}>
                                        {banner.description}
                                    </p>
                                )}
                                
                            </div>
                        </div>
                    </SwiperSlide>
                ))}
            </Swiper>
        </section>
    );
}