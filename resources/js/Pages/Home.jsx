import React from 'react';
import { Head } from '@inertiajs/react';
import FrontLayout from '../Layouts/FrontLayout';

import BannerSlider from '../Components/HomeSections/BannerSlider';
import ToursCategory from '../Components/HomeSections/ToursCategory';
import PopularTours from '../Components/HomeSections/PopularTours';
import UpcomingPackages from '../Components/HomeSections/UpcomingPackages';
import InfoSection from '../Components/HomeSections/InfoSection';
import ServiceSection from '../Components/HomeSections/ServiceSection';
import ReviewSection from '../Components/HomeSections/ReviewSection';

export default function Home({
    banners,
    categories,
    popularTours,
    upcomingPackages,
    services,
    reviews,
    infoSection,
}) {
    return (
        <>
            <Head title="Home" />
            
            <BannerSlider banners={banners} />
            <ToursCategory categories={categories} />
            <PopularTours packages={popularTours} />
            <UpcomingPackages packages={upcomingPackages} />
            <InfoSection data={infoSection} />
            <ServiceSection services={services} />
            <ReviewSection reviews={reviews} />
        </>
    );
}

Home.layout = (page) => <FrontLayout>{page}</FrontLayout>;