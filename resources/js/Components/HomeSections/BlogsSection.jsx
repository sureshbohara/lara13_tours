import React from 'react';
import { Link } from '@inertiajs/react';
import { route } from 'ziggy-js';

export default function BlogsSection({ featuredBlog, recentBlogs }) {
    if (!featuredBlog && (!recentBlogs || recentBlogs.length === 0)) return null;

    return (
        <section className="blogs-section section">
            <div className="container">
                <div className="section-header text-center mb-5">
                    <h2 className="section-title">Mountain Stories, Guides & Practical Advice</h2>
                    <p className="section-subtitle">Planning a Himalayan journey involves many questions. Our travel journal brings together expedition information, trekking guides, climbing advice, route comparisons, equipment guidance, and stories from the mountains to help you prepare before arriving in Nepal.</p>
                </div>
                <div className="blogs-wrapper">
                    <div className="blogs-main">
                        {featuredBlog && (
                            <Link href={route('blog.details', { slug: featuredBlog.slug })} className="text-decoration-none text-dark">
                                <article className="blog-card-main">
                                    <img src={featuredBlog.image_url} alt={featuredBlog.title} className="blog-image-main" />
                                    <div className="blog-content-main">
                                        <h3 className="blog-title-main">{featuredBlog.title}</h3>
                                        <p className="blog-excerpt-main">{featuredBlog.excerpt}</p>
                                    </div>
                                </article>
                            </Link>
                        )}
                    </div>
                    <div className="blogs-sidebar">
                        {recentBlogs && recentBlogs.map((blog, index) => (
                            <Link key={blog.id} href={route('blog.details', { slug: blog.slug })} className="text-decoration-none text-dark">
                                <article className="blog-card-small">
                                    <img src={blog.image_url || '/default/noimage.png'} alt={blog.title} className="blog-image-small" />
                                    <div className="blog-content-small">
                                        <h4 className="blog-title-small">{blog.title}</h4>
                                        <p className="blog-excerpt-small">{blog.excerpt}</p>
                                    </div>
                                </article>
                            </Link>
                        ))}
                    </div>
                </div>
            </div>
        </section>
    );
}