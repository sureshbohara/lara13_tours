import React from 'react';
import { Head, usePage } from '@inertiajs/react';
import FrontLayout from '../Layouts/FrontLayout';

import BannerSlider from '../Components/HomeSections/BannerSlider';
import ContentSection from '../Components/HomeSections/ContentSection';
import DistanceSection from '../Components/HomeSections/DistanceSection';
import PackageSection from '../Components/HomeSections/PackageSection';
import UpcomingPackagesSection from '../Components/HomeSections/UpcomingPackagesSection'; 
import ChooseSection from '../Components/HomeSections/ChooseSection';
import CuratedTreksSection from '../Components/HomeSections/CuratedTreksSection';
import BlogsSection from '../Components/HomeSections/BlogsSection';
import TestimonialsSection from '../Components/HomeSections/TestimonialsSection';
import AffiliationsSection from '../Components/HomeSections/AffiliationsSection';
import NewsletterSection from '../Components/HomeSections/NewsletterSection';

export default function Home({ 
    banners, 
    destinationCategory, 
    trekkingCategory,
    popularTours, 
    upcomingPackages,
    reviews,
    featuredBlog,  
    recentBlogs,
    teamMemberships
}) {
    const { props } = usePage();
    const setting = props.setting || {};

    return (
        <>

            <Head>
                <title>{setting.meta_title || setting.system_name || 'SP Travel and Tours'}</title>
                {setting.meta_description && <meta name="description" content={setting.meta_description} />}
                {setting.meta_keywords && <meta name="keywords" content={setting.meta_keywords} />}
            </Head>
            
            <BannerSlider banners={banners} />
            <ContentSection />
            <DistanceSection destinationCategory={destinationCategory} />
            <PackageSection packages={popularTours} /> 
            <UpcomingPackagesSection packages={upcomingPackages} />
            <ChooseSection />
            <CuratedTreksSection trekkingCategory={trekkingCategory} />
            <BlogsSection featuredBlog={featuredBlog} recentBlogs={recentBlogs} />
            <TestimonialsSection reviews={reviews} />
            <AffiliationsSection teamMemberships={teamMemberships} />
            <NewsletterSection />
        </>
    );
}

Home.layout = (page) => <FrontLayout>{page}</FrontLayout>;