import React from 'react';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay, Navigation, Pagination } from 'swiper/modules';
import { Link, usePage } from '@inertiajs/react';
import { route } from 'ziggy-js';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

export default function CuratedTreksSection() {
    const { props } = usePage();
    const trekkingCategory = props.trekkingCategory || null;
    const trekkingRegions = trekkingCategory?.children || [];

    if (!trekkingRegions || trekkingRegions.length === 0) return null;

    return (
        <section className="curated-treks-section section">
            <div className="container">
                <div className="section-header text-center mb-5">
                    <h2 className="section-title">{trekkingCategory.name || 'CURATED TREKS & EXPEDITIONS'}</h2>
                    <p className="section-subtitle">{trekkingCategory.excerpt || 'Enjoy curated treks and Mountaineering, thoughtfully designed by local experts.'}</p>
                </div>
                <div className="curated-carousel-wrapper position-relative">
                    <Swiper
                        modules={[Autoplay, Navigation, Pagination]}
                        spaceBetween={20}
                        slidesPerView={1}
                        loop={trekkingRegions.length > 1}
                        autoplay={{ delay: 5000, disableOnInteraction: false, pauseOnMouseEnter: true }}
                        speed={600}
                        navigation={trekkingRegions.length > 1 ? { nextEl: '.swiper-button-next-custom', prevEl: '.swiper-button-prev-custom' } : false}
                        pagination={trekkingRegions.length > 1 ? { el: '.swiper-pagination-custom', clickable: true } : false}
                        breakpoints={{ 576: { slidesPerView: 2 }, 768: { slidesPerView: 2 }, 992: { slidesPerView: 3 }, 1200: { slidesPerView: 4 } }}
                    >
                        {trekkingRegions.map((region) => (
                            <SwiperSlide key={region.id}>
                                <Link href={route('packages.category', { slug: region.slug })} className="curated-item" style={{ textDecoration: 'none', color: 'inherit' }}>
                                    <div className="curated-image-wrapper">
                                        <img src={region.image_url || '/default/noimage.png'} alt={region.name} className="curated-image" />
                                        <div className="curated-overlay">
                                            <div className="curated-content">
                                                <h3>{region.name}</h3>
                                                <p>Explore Region</p>
                                            </div>
                                        </div>
                                    </div>
                                </Link>
                            </SwiperSlide>
                        ))}
                    </Swiper>
                </div>
            </div>
        </section>
    );
}