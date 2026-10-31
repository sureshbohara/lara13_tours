import React from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import FrontLayout from '../Layouts/FrontLayout';

export default function BlogDetails({ blog, popularPosts }) {
    const { props } = usePage();
    const setting = props.setting || {};


    const heroImage = blog.image_url || blog.image;

    return (
        <>
            {/* ================= DYNAMIC SEO ================= */}
            <Head>
                <title>{blog.meta_title || blog.title + ' | ' + (setting.system_name || 'SP Travel and Tours')}</title>
                <meta name="description" content={blog.meta_description || blog.excerpt || 'Read more about this travel story.'} />
                <meta name="keywords" content={blog.meta_keywords || 'travel, nepal, blog, himalayas'} />
            </Head>

            {/* ================= HERO HEADER ================= */}
            <section className="listing-page-header" style={{
                background: `linear-gradient(to right, rgba(15,26,46,0.85), rgba(15,26,46,0.7)), url('${heroImage}')`,
                backgroundSize: 'cover',
                backgroundPosition: 'center',
                padding: '180px 0 100px'
            }}>
                <div className="container text-center">
                               


                    <h1 style={{ color: 'white', fontSize: 'clamp(2rem, 4vw, 3rem)', marginBottom: '20px', lineHeight: '1.2' }}>
                        {blog.title}
                    </h1>

                 
                    <div style={{ display: 'flex', justifyContent: 'center', gap: '25px', color: 'rgba(255,255,255,0.8)', fontSize: '14px' }}>
                        <span style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
                            <i className="bi bi-calendar3" style={{ color: 'var(--theme-accent)' }}></i>
                            {new Date(blog.created_at).toLocaleDateString('en-US', { day: 'numeric', month: 'long', year: 'numeric' })}
                        </span>
                        <span style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
                            <i className="bi bi-eye" style={{ color: 'var(--theme-accent)' }}></i>
                            {blog.views || 0} Views
                        </span>
                    </div>
                </div>
            </section>

           
            <section className="section" style={{ background: 'var(--bg-soft)', padding: '60px 0' }}>
                <div className="container">
                    <div className="row">
                        
                    
                        <div className="col-lg-8">
                            <div className="blog-content-wrapper" style={{
                                background: 'var(--bg-white)',
                                padding: '20px',
                             
                            }}>
                      
                                <img 
                                    src={heroImage} 
                                    alt={blog.title} 
                                    style={{ width: '100%', borderRadius: '8px', marginBottom: '30px', maxHeight: '500px', objectFit: 'cover' }} 
                                />

                         
                                {blog.excerpt && (
                                    <p style={{ 
                                        fontSize: '1.2rem', 
                                        color: 'var(--theme-primary)', 
                                        fontStyle: 'italic', 
                                        borderLeft: '4px solid var(--theme-accent)', 
                                        paddingLeft: '20px', 
                                        marginBottom: '30px',
                                        lineHeight: '1.6'
                                    }}>
                                        {blog.excerpt}
                                    </p>
                                )}

                       
                                <div 
                                    className="blog-body"
                                    style={{ 
                                        fontSize: '16px', 
                                        color: 'var(--text-main)', 
                                        lineHeight: '1.8' 
                                    }}
                                    dangerouslySetInnerHTML={{ __html: blog.description || blog.content || 'No content available.' }} 
                                />

                           
                                <div style={{ 
                                    marginTop: '40px', 
                                    paddingTop: '30px', 
                                    borderTop: '1px solid var(--border-color)',
                                    display: 'flex',
                                    justifyContent: 'space-between',
                                    alignItems: 'center'
                                }}>
                                    <div style={{ display: 'flex', gap: '10px' }}>
                                        <span style={{ fontWeight: '600', color: 'var(--theme-primary)' }}>Share:</span>
                                        <a href="#" style={{ color: 'var(--theme-primary)', fontSize: '18px' }}><i className="bi bi-facebook"></i></a>
                                        <a href="#" style={{ color: 'var(--theme-primary)', fontSize: '18px' }}><i className="bi bi-twitter"></i></a>
                                        <a href="#" style={{ color: 'var(--theme-primary)', fontSize: '18px' }}><i className="bi bi-linkedin"></i></a>
                                    </div>
                                    <Link href="/blogs" className="btn-read-more" style={{ 
                                        display: 'inline-flex', alignItems: 'center', gap: '8px',
                                        background: 'var(--theme-primary)', color: 'white', padding: '10px 24px',
                                        borderRadius: '50px', fontSize: '14px', fontWeight: '600', textDecoration: 'none'
                                    }}>
                                        <i className="bi bi-arrow-left"></i> Back to Blogs
                                    </Link>
                                </div>
                            </div>
                        </div>

                    
                        <div className="col-lg-4">
                            <div className="sidebar-widget" style={{
                                background: 'var(--bg-white)',
                                padding: '30px',
                                boxShadow: 'var(--shadow-md)',
                                position: 'sticky',
                                top: '100px'
                            }}>
                                <h3 style={{
                                    fontFamily: 'Poppins, sans-serif',
                                    fontSize: '20px',
                                    fontWeight: '700',
                                    color: 'var(--theme-primary)',
                                    marginBottom: '25px',
                                    paddingBottom: '15px',
                                    borderBottom: '2px solid var(--theme-accent)'
                                }}>
                                    Popular Posts
                                </h3>

                                <div style={{ display: 'flex', flexDirection: 'column', gap: '20px' }}>
                                    {popularPosts && popularPosts.length > 0 ? (
                                        popularPosts.map((post, index) => (
                                            <div key={post.id || index} style={{
                                                display: 'flex',
                                                gap: '15px',
                                                paddingBottom: index < popularPosts.length - 1 ? '20px' : '0',
                                                borderBottom: index < popularPosts.length - 1 ? '1px solid var(--border-color)' : 'none'
                                            }}>
                                                <div style={{
                                                    width: '80px',
                                                    height: '80px',
                                                    borderRadius: '8px',
                                                    overflow: 'hidden',
                                                    flexShrink: 0
                                                }}>
                                                    <img 
                                                        src={post.image_url || post.image || 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w=200'} 
                                                        alt={post.title}
                                                        style={{ width: '100%', height: '100%', objectFit: 'cover' }}
                                                    />
                                                </div>
                                                <div style={{ flex: 1 }}>
                                                    <span style={{
                                                        fontSize: '11px',
                                                        color: 'var(--theme-accent)',
                                                        fontWeight: '600',
                                                        textTransform: 'uppercase',
                                                        display: 'block',
                                                        marginBottom: '5px'
                                                    }}>
                                                        {post.categories && post.categories.length > 0 ? post.categories[0].name : 'BLOG'}
                                                    </span>
                                                    <h4 style={{
                                                        fontFamily: 'Poppins, sans-serif',
                                                        fontSize: '14px',
                                                        fontWeight: '700',
                                                        color: 'var(--theme-primary)',
                                                        marginBottom: '8px',
                                                        lineHeight: '1.4'
                                                    }}>
                                                        <Link href={`/blogs/${post.slug}`} style={{
                                                            textDecoration: 'none',
                                                            color: 'inherit',
                                                            transition: 'var(--transition)'
                                                        }}
                                                        onMouseEnter={(e) => e.target.style.color = 'var(--theme-accent)'}
                                                        onMouseLeave={(e) => e.target.style.color = 'var(--theme-primary)'}
                                                        >
                                                            {post.title}
                                                        </Link>
                                                    </h4>
                                                    <div style={{
                                                        fontSize: '12px',
                                                        color: 'var(--text-muted)',
                                                        display: 'flex',
                                                        alignItems: 'center',
                                                        gap: '10px'
                                                    }}>
                                                        <span><i className="bi bi-eye"></i> {post.views || 0}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        ))
                                    ) : (
                                        <p style={{ color: 'var(--text-muted)', textAlign: 'center', padding: '20px' }}>
                                            No popular posts
                                        </p>
                                    )}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </>
    );
}

BlogDetails.layout = (page) => <FrontLayout>{page}</FrontLayout>;