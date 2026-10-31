import React from 'react';

export default function PackageSidebar({ pkg, setting, onBookClick }) {
    
    const handlePrintPDF = () => {

        const pdfArea = document.getElementById('printable-pdf-area');
        if (!pdfArea) return;
        
        pdfArea.style.display = 'block';
        pdfArea.style.position = 'static';
        pdfArea.style.left = '0';
        pdfArea.style.opacity = '1';
        
        window.print();
        

        setTimeout(() => {
            pdfArea.style.display = 'none';
            pdfArea.style.position = 'absolute';
            pdfArea.style.left = '-9999px';
        }, 1000);
    };

    return (
        <aside className="col-lg-3">
            <div className="sidebar-price-card" id="info-bar">
                <header className="sidebar-price-header">
                    <span className="price-label">Starting Price</span>
                    <div className="sidebar-discounted-price">
                        ${Number(pkg?.trip_price || 0).toLocaleString()} 
                        <span style={{ fontSize: '16px', fontWeight: 500, color: 'rgba(255,255,255,0.8)' }}> / Person</span>
                    </div>
                    {pkg?.trip_previous_price && (
                        <div className="text-decoration-line-through text-white-50 mt-1" style={{ fontSize: '16px' }}>
                            ${Number(pkg.trip_previous_price).toLocaleString()}
                        </div>
                    )}
                </header>

                {pkg?.group_size_price && pkg.group_size_price.length > 0 && (
                    <section className="group-pricing-section">
                        <h4 className="sidebar-mini-title"><i className="bi bi-people-fill"></i> Group Pricing</h4>
                        <table className="custom-price-table">
                            <tbody>
                                {pkg.group_size_price.map((group, idx) => (
                                    <tr key={idx}>
                                        <td className="label-col">{group.label}</td>
                                        <td className="price-col">${Number(group.price).toLocaleString()}</td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </section>
                )}

                <section className="why-book-section">
                    <h4 className="sidebar-mini-title"><i className="bi bi-shield-check"></i> Why Book With Us?</h4>
                    <ul className="benefits-list">
                        <li><i className="bi bi-shield-check"></i><span>Book with Confidence</span></li>
                        <li><i className="bi bi-credit-card-2-front"></i><span>Secure & Flexible Payments</span></li>
                        <li><i className="bi bi-lightning-charge"></i><span>Instant Confirmation</span></li>
                        <li><i className="bi bi-headset"></i><span>24/7 Customer Support</span></li>
                    </ul>

                    <div className="sidebar-cta-group">
                        <button type="button" className="btn-solid" onClick={onBookClick}>
                            <i className="bi bi-calendar-check me-2"></i> Book Now
                        </button>
                        
                        <button 
                            type="button" 
                            className="btn-outline-dark w-100" 
                            onClick={handlePrintPDF}
                            style={{ 
                                border: '2px solid var(--theme-primary)', 
                                color: 'var(--theme-primary)', 
                                fontWeight: 600, 
                                padding: '14px 24px', 
                                borderRadius: '50px', 
                                width: '100%', 
                                textAlign: 'center', 
                                transition: 'var(--transition)', 
                                background: 'transparent', 
                                cursor: 'pointer' 
                            }}
                        >
                            <i className="bi bi-file-earmark-pdf me-2"></i> Download PDF
                        </button>
                    </div>
                </section>

                <footer className="help-contact">
                    <p className="help-text">Have a question about this trip?</p>
                    <a href={`https://wa.me/${setting.phone?.replace(/\D/g, '') || '9779849352533'}`} className="whatsapp-link">
                        <i className="bi bi-whatsapp"></i> <span>Chat on WhatsApp</span>
                    </a>
                </footer>
            </div>
        </aside>
    );
}