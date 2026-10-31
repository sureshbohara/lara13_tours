import React from 'react';
import FrontLayout from '../Layouts/FrontLayout';
import { Head, Link, router, usePage } from '@inertiajs/react';
import PackageCard from '../Components/UI/PackageCard';
import FilterSidebar from '../Components/UI/FilterSidebar'; 

export default function Listing({ category, subCategories, packages, breadcrumbs, filters }) {
    const { props } = usePage();
    const setting = props.setting || {};
    
    const bgImage = category?.image_url || 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w=1920&auto=format&fit=crop';

       const handleFilterChange = (key, value) => {
        if (key === 'reset') {
            router.get(window.location.pathname, {}, { preserveState: true, preserveScroll: true });
            return;
        }

        const params = new URLSearchParams(window.location.search);
        if (value) {
            params.set(key, value);
        } else {
            params.delete(key);
        }
        
        const queryString = params.toString();
        const newUrl = queryString ? `${window.location.pathname}?${queryString}` : window.location.pathname;
        
        router.get(newUrl, {}, { preserveState: true, preserveScroll: true });
    };

    const toggleMobileFilter = () => {
        const sidebar = document.getElementById('filterSidebar');
        const overlay = document.getElementById('filterOverlay');
        sidebar?.classList.toggle('show');
        overlay?.classList.toggle('show');
        document.body.style.overflow = sidebar?.classList.contains('show') ? 'hidden' : '';
    };

    const pageTitle = category?.name ? `${category.name} | ${setting.system_name || 'SP Travel and Tours'}` : setting.system_name || 'SP Travel and Tours';
    const metaDescription = category?.meta_description || setting.meta_description || 'Find the perfect trek, climb, or tour.';
    const metaKeywords = category?.meta_keywords || setting.meta_keywords || 'travel, nepal, trekking';

    return (
        <>
            <Head title={pageTitle}>
                <meta name="description" content={metaDescription} />
                <meta name="keywords" content={metaKeywords} />
            </Head>
            
            <section 
                className="listing-page-header"
                style={{
                    background: `linear-gradient(to right, rgba(15,26,46,0.9), rgba(15,26,46,0.7)), url('${bgImage}')`,
                    backgroundSize: 'cover',
                    backgroundPosition: 'center'
                }}
            >
                <div className="container">
                    <h1>{category?.name}</h1>
                    <p>{category?.excerpt || 'Find the perfect trek, climb, or tour tailored to your dreams.'}</p>
                </div>
            </section>

            <section className="package-listing-section section">
                <div className="container">
                    {category?.description && (
                        <div className="row mb-4">
                            <p style={{ color: 'var(--text-muted)', fontSize: '16px', margin: '0 auto' }}>
                                {category.description}
                            </p>
                        </div>
                    )}
                
                    <button className="mobile-filter-toggle" onClick={toggleMobileFilter}>
                        <i className="bi bi-funnel-fill"></i> Filters & Categories
                    </button>
                    <div className="filter-overlay" id="filterOverlay" onClick={toggleMobileFilter}></div>

                    <div className="row">
                        <div className="col-lg-3 mb-4">
    
                            <FilterSidebar 
                                category={category}
                                subCategories={subCategories}
                                packages={packages}
                                filters={filters}
                                onFilterChange={handleFilterChange}
                            />
                        </div>

                        <div className="col-lg-9">
                            <div className="listing-top-bar">
                                <div className="results-count">Showing <span>{packages.from || 0}-{packages.to || 0}</span> of <span>{packages.total}</span> results</div>
                                <div className="sort-dropdown">
                                    <select value={filters.sort || 'popular'} onChange={(e) => handleFilterChange('sort', e.target.value)}>
                                        <option value="popular">Sort by: Popularity</option>
                                        <option value="price_low">Price: Low to High</option>
                                        <option value="price_high">Price: High to Low</option>
                                        <option value="newest">Newest First</option>
                                    </select>
                                </div>
                            </div>

                            {packages.data.length > 0 ? (
                                <div className="row g-4">
                                    {packages.data.map((pkg) => (
                                        <div className="col-lg-6 col-md-6" key={pkg.id}>
                                            <PackageCard package={pkg} />
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <div style={{ background: 'white', padding: '60px 30px', borderRadius: 'var(--radius)', textAlign: 'center', boxShadow: 'var(--shadow-md)' }}>
                                    <i className="bi bi-inbox" style={{ fontSize: '60px', color: 'var(--text-muted)', opacity: 0.3 }}></i>
                                    <h4 style={{ marginTop: '20px', color: 'var(--theme-primary)' }}>No Packages Found</h4>
                                    <p style={{ color: 'var(--text-muted)' }}>We couldn't find any packages matching your criteria.</p>
                                </div>
                            )}

                            {packages.links.length > 3 && (
                                <nav className="pagination-custom mt-5">
                                    {packages.links.map((link, index) => {
                                        if (link.label.includes('Previous')) {
                                            return (
                                                <Link key={index} href={link.url || '#'} className={`page-link ${!link.url ? 'disabled' : ''}`} preserveScroll>
                                                    <i className="bi bi-chevron-left"></i>
                                                </Link>
                                            );
                                        }
                                        if (link.label.includes('Next')) {
                                            return (
                                                <Link key={index} href={link.url || '#'} className={`page-link ${!link.url ? 'disabled' : ''}`} preserveScroll>
                                                    <i className="bi bi-chevron-right"></i>
                                                </Link>
                                            );
                                        }
                                        return (
                                            <Link key={index} href={link.url || '#'} className={`page-link ${link.active ? 'active' : ''}`} preserveScroll dangerouslySetInnerHTML={{ __html: link.label }} />
                                        );
                                    })}
                                </nav>
                            )}
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

Listing.layout = (page) => <FrontLayout>{page}</FrontLayout>;