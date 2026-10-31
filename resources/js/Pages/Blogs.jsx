import React from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import FrontLayout from '../Layouts/FrontLayout';
import PageHeader from '../Components/Shared/PageHeader';
import { route } from 'ziggy-js';
export default function Blogs({ blogs, popularPosts }) {

    const { props } = usePage();
    const setting = props.setting || {};

    return (
        <>
            <Head>
                <title>{setting.meta_title || 'Blog | ' + (setting.system_name || 'SP Travel and Tours')}</title>
                {setting.meta_description && <meta name="description" content={setting.meta_description} />}
                {setting.meta_keywords && <meta name="keywords" content={setting.meta_keywords} />}
            </Head>


            <PageHeader title="Our Blog" subtitle="Travel tips, guides, and stories from the Himalayas" />

           
            <section className="section" style={{ background: 'var(--bg-soft)', padding: '60px 0' }}>
                <div className="container">
                    <div className="row">
                        <div className="col-lg-8">
                            <div className="row g-4">
                                {blogs && blogs.data && blogs.data.length > 0 ? (
                                    blogs.data.map((blog, index) => (
                                        <div className="col-md-6" key={blog.id || index}>
                                            <div className="blog-card" style={{
                                                background: 'var(--bg-white)',
                                                borderRadius: 'var(--radius)',
                                                overflow: 'hidden',
                                                boxShadow: 'var(--shadow-md)',
                                                transition: 'var(--transition)',
                                                height: '100%',
                                                display: 'flex',
                                                flexDirection: 'column'
                                            }}
                                            onMouseEnter={(e) => {
                                                e.currentTarget.style.transform = 'translateY(-5px)';
                                                e.currentTarget.style.boxShadow = '0 15px 35px rgba(26, 43, 76, 0.15)';
                                            }}
                                            onMouseLeave={(e) => {
                                                e.currentTarget.style.transform = 'translateY(0)';
                                                e.currentTarget.style.boxShadow = 'var(--shadow-md)';
                                            }}
                                            >
                                            
                                                <div style={{
                                                    position: 'relative',
                                                    overflow: 'hidden',
                                                    height: '220px'
                                                }}>
                                                    <img 
                                                        src={blog.image_url || blog.image} 
                                                        alt={blog.title}
                                                        style={{
                                                            width: '100%',
                                                            height: '100%',
                                                            objectFit: 'cover',
                                                            transition: 'transform 0.5s ease'
                                                        }}
                                                        onMouseEnter={(e) => e.target.style.transform = 'scale(1.1)'}
                                                        onMouseLeave={(e) => e.target.style.transform = 'scale(1)'}
                                                    />
                                                    
                                                 
                                                    {blog.categories && blog.categories.length > 0 && (
                                                        <span style={{
                                                            position: 'absolute',
                                                            top: '15px',
                                                            left: '15px',
                                                            background: 'var(--theme-accent)',
                                                            color: 'var(--theme-dark)',
                                                            padding: '5px 15px',
                                                            borderRadius: '50px',
                                                            fontSize: '12px',
                                                            fontWeight: '700',
                                                            textTransform: 'uppercase'
                                                        }}>
                                                            {blog.categories[0].name}
                                                        </span>
                                                    )}
                                                </div>

                                               
                                                <div style={{ padding: '25px', flex: 1, display: 'flex', flexDirection: 'column' }}>
                                                    <h3 style={{
                                                        fontFamily: 'Poppins, sans-serif',
                                                        fontSize: '18px',
                                                        fontWeight: '700',
                                                        color: 'var(--theme-primary)',
                                                        marginBottom: '15px',
                                                        lineHeight: '1.4'
                                                    }}>
                                                        <Link href={route('blog.details', { slug: blog.slug })} style={{
                                                            textDecoration: 'none',
                                                            color: 'inherit',
                                                            transition: 'var(--transition)'
                                                        }}
                                                        onMouseEnter={(e) => e.target.style.color = 'var(--theme-accent)'}
                                                        onMouseLeave={(e) => e.target.style.color = 'var(--theme-primary)'}
                                                        >
                                                            {blog.title}
                                                        </Link>
                                                    </h3>

                                                    <p style={{
                                                        fontSize: '14px',
                                                        color: 'var(--text-muted)',
                                                        lineHeight: '1.7',
                                                        marginBottom: '20px',
                                                        flex: 1
                                                    }}>
                                                        {blog.excerpt?.substring(0, 120)}...
                                                    </p>

                                         
                                                    <div style={{
                                                        display: 'flex',
                                                        alignItems: 'center',
                                                        justifyContent: 'space-between',
                                                        paddingTop: '15px',
                                                        borderTop: '1px solid var(--border-color)',
                                                        fontSize: '13px',
                                                        color: 'var(--text-muted)'
                                                    }}>
                                                        <div style={{ display: 'flex', alignItems: 'center', gap: '15px' }}>
                                                            <span style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                                                                <i className="bi bi-eye" style={{ color: 'var(--theme-accent)' }}></i>
                                                                {blog.views || 0}
                                                            </span>
                                                        </div>
                                                        <span>
                                                            {blog.created_at ? new Date(blog.created_at).toLocaleDateString('en-US', { 
                                                                day: 'numeric', 
                                                                month: 'short', 
                                                                year: 'numeric' 
                                                            }) : ''}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ))
                                ) : (
                                    <div className="col-12 text-center py-5">
                                        <i className="bi bi-inbox" style={{ fontSize: '48px', color: 'var(--text-muted)', opacity: 0.3 }}></i>
                                        <p style={{ marginTop: '20px', color: 'var(--text-muted)' }}>No blog posts found</p>
                                    </div>
                                )}
                            </div>

                    
                            {blogs && blogs.links && blogs.links.length > 3 && (
                                <div className="pagination-custom" style={{ marginTop: '40px', display: 'flex', justifyContent: 'center', gap: '8px' }}>
                                    {blogs.links.map((link, index) => (
                                        <Link 
                                            key={index}
                                            href={link.url || '#'}
                                            className="page-link" 
                                            style={{
                                                width: '42px',
                                                height: '42px',
                                                display: 'flex',
                                                alignItems: 'center',
                                                justifyContent: 'center',
                                                borderRadius: '8px',
                                                border: '1px solid rgba(26, 43, 76, 0.15)',
                                                background: link.active ? 'var(--theme-accent)' : 'var(--bg-white)',
                                                color: link.active ? 'var(--theme-dark)' : 'var(--text-main)',
                                                cursor: link.url ? 'pointer' : 'not-allowed',
                                                transition: 'var(--transition)',
                                                textDecoration: 'none'
                                            }}
                                            dangerouslySetInnerHTML={{ __html: link.label }}
                                        />
                                    ))}
                                </div>
                            )}
                        </div>

                     
                        <div className="col-lg-4">
                            <div className="sidebar-widget" style={{
                                background: 'var(--bg-white)',
                                borderRadius: 'var(--radius)',
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
                                                        src={post.image_url || post.image} 
                                                        alt={post.title}
                                                        style={{
                                                            width: '100%',
                                                            height: '100%',
                                                            objectFit: 'cover'
                                                        }}
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
                                                        {post.categories && post.categories.length > 0 ? post.categories[0].name : 'EXPEDITION'}
                                                    </span>
                                                    <h4 style={{
                                                        fontFamily: 'Poppins, sans-serif',
                                                        fontSize: '14px',
                                                        fontWeight: '700',
                                                        color: 'var(--theme-primary)',
                                                        marginBottom: '8px',
                                                        lineHeight: '1.4'
                                                    }}>
                                                        <Link href={route('blog.details', { slug: post.slug })} style={{
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
                                                        <span>
                                                            {post.created_at ? new Date(post.created_at).toLocaleDateString('en-US', { 
                                                                day: 'numeric', 
                                                                month: 'short', 
                                                                year: 'numeric' 
                                                            }) : ''}
                                                        </span>
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

Blogs.layout = (page) => <FrontLayout>{page}</FrontLayout>;