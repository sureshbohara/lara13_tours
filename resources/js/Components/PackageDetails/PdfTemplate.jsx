import React from 'react';

export default function PdfTemplate({ pkg, setting, equipmentCategories }) {
    return (
        <div id="printable-pdf-area">
            <div style={{ 
                fontFamily: 'Arial, sans-serif', 
                color: '#333', 
                fontSize: '14px', 
                lineHeight: '1.6', 
                padding: '0', 
                backgroundColor: '#ffffff',
                width: '100%',
                boxSizing: 'border-box'
            }}>
                {/* Header with Image */}
                <div style={{ 
                    position: 'relative', 
                    marginBottom: '0',
                    overflow: 'hidden'
                }}>
                    <img 
                        src={pkg.feature_image_url || pkg.image_url} 
                        alt={pkg.name}
                        crossOrigin="anonymous"
                        style={{ 
                            width: '100%', 
                            height: '400px', 
                            objectFit: 'cover',
                            display: 'block'
                        }}
                    />
                    <div style={{ 
                        position: 'absolute',
                        bottom: 0,
                        left: 0,
                        right: 0,
                        background: 'linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.5) 50%, transparent 100%)',
                        padding: '60px 40px 40px'
                    }}>
                        <h1 style={{ 
                            color: '#fff', 
                            fontSize: '36px', 
                            fontWeight: 'bold',
                            margin: '0 0 15px 0',
                            textShadow: '2px 2px 4px rgba(0,0,0,0.5)'
                        }}>
                            {pkg.name}
                        </h1>
                        <div style={{ 
                            display: 'inline-block',
                            background: '#D4AF6A',
                            color: '#1A2B4C',
                            padding: '12px 30px',
                            borderRadius: '50px',
                            fontWeight: 'bold',
                            fontSize: '18px',
                            boxShadow: '0 4px 15px rgba(0,0,0,0.3)'
                        }}>
                            Starting from ${Number(pkg.trip_price).toLocaleString()} / Person
                        </div>
                    </div>
                </div>

                {/* Main Content Container */}
                <div style={{ padding: '40px' }}>
                    {/* Excerpt */}
                    {pkg.excerpt && (
                        <p style={{ 
                            fontSize: '16px', 
                            color: '#555', 
                            marginBottom: '40px',
                            textAlign: 'justify',
                            lineHeight: '1.8',
                            fontStyle: 'italic',
                            borderLeft: '4px solid #D4AF6A',
                            paddingLeft: '20px'
                        }}>
                            {pkg.excerpt}
                        </p>
                    )}

                    {/* Quick Info Grid */}
                    <div style={{ 
                        display: 'grid',
                        gridTemplateColumns: 'repeat(3, 1fr)',
                        gap: '20px',
                        marginBottom: '40px'
                    }}>
                        {pkg.duration && (
                            <div style={{ 
                                background: 'linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%)',
                                border: '2px solid #e9ecef',
                                borderRadius: '12px',
                                padding: '20px',
                                display: 'flex',
                                alignItems: 'center',
                                boxShadow: '0 2px 8px rgba(0,0,0,0.05)'
                            }}>
                                <div style={{ 
                                    fontSize: '32px', 
                                    marginRight: '15px',
                                    width: '50px',
                                    height: '50px',
                                    background: '#fff',
                                    borderRadius: '50%',
                                    display: 'flex',
                                    alignItems: 'center',
                                    justifyContent: 'center',
                                    boxShadow: '0 2px 4px rgba(0,0,0,0.1)'
                                }}>⏱️</div>
                                <div>
                                    <div style={{ fontSize: '11px', textTransform: 'uppercase', color: '#888', marginBottom: '4px', fontWeight: '600' }}>Duration</div>
                                    <div style={{ fontWeight: 'bold', fontSize: '16px', color: '#1A2B4C' }}>{pkg.duration}</div>
                                </div>
                            </div>
                        )}
                        {pkg.transportation && (
                            <div style={{ 
                                background: 'linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%)',
                                border: '2px solid #e9ecef',
                                borderRadius: '12px',
                                padding: '20px',
                                display: 'flex',
                                alignItems: 'center',
                                boxShadow: '0 2px 8px rgba(0,0,0,0.05)'
                            }}>
                                <div style={{ 
                                    fontSize: '32px', 
                                    marginRight: '15px',
                                    width: '50px',
                                    height: '50px',
                                    background: '#fff',
                                    borderRadius: '50%',
                                    display: 'flex',
                                    alignItems: 'center',
                                    justifyContent: 'center',
                                    boxShadow: '0 2px 4px rgba(0,0,0,0.1)'
                                }}>🚗</div>
                                <div>
                                    <div style={{ fontSize: '11px', textTransform: 'uppercase', color: '#888', marginBottom: '4px', fontWeight: '600' }}>Transport</div>
                                    <div style={{ fontWeight: 'bold', fontSize: '16px', color: '#1A2B4C' }}>{pkg.transportation}</div>
                                </div>
                            </div>
                        )}
                        {pkg.trip_grading && (
                            <div style={{ 
                                background: 'linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%)',
                                border: '2px solid #e9ecef',
                                borderRadius: '12px',
                                padding: '20px',
                                display: 'flex',
                                alignItems: 'center',
                                boxShadow: '0 2px 8px rgba(0,0,0,0.05)'
                            }}>
                                <div style={{ 
                                    fontSize: '32px', 
                                    marginRight: '15px',
                                    width: '50px',
                                    height: '50px',
                                    background: '#fff',
                                    borderRadius: '50%',
                                    display: 'flex',
                                    alignItems: 'center',
                                    justifyContent: 'center',
                                    boxShadow: '0 2px 4px rgba(0,0,0,0.1)'
                                }}>📊</div>
                                <div>
                                    <div style={{ fontSize: '11px', textTransform: 'uppercase', color: '#888', marginBottom: '4px', fontWeight: '600' }}>Grade</div>
                                    <div style={{ fontWeight: 'bold', fontSize: '16px', color: '#1A2B4C' }}>{pkg.trip_grading}</div>
                                </div>
                            </div>
                        )}
                        {pkg.max_altitude && (
                            <div style={{ 
                                background: 'linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%)',
                                border: '2px solid #e9ecef',
                                borderRadius: '12px',
                                padding: '20px',
                                display: 'flex',
                                alignItems: 'center',
                                boxShadow: '0 2px 8px rgba(0,0,0,0.05)'
                            }}>
                                <div style={{ 
                                    fontSize: '32px', 
                                    marginRight: '15px',
                                    width: '50px',
                                    height: '50px',
                                    background: '#fff',
                                    borderRadius: '50%',
                                    display: 'flex',
                                    alignItems: 'center',
                                    justifyContent: 'center',
                                    boxShadow: '0 2px 4px rgba(0,0,0,0.1)'
                                }}>🏔️</div>
                                <div>
                                    <div style={{ fontSize: '11px', textTransform: 'uppercase', color: '#888', marginBottom: '4px', fontWeight: '600' }}>Max Altitude</div>
                                    <div style={{ fontWeight: 'bold', fontSize: '16px', color: '#1A2B4C' }}>{pkg.max_altitude}</div>
                                </div>
                            </div>
                        )}
                        {pkg.accommodation && (
                            <div style={{ 
                                background: 'linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%)',
                                border: '2px solid #e9ecef',
                                borderRadius: '12px',
                                padding: '20px',
                                display: 'flex',
                                alignItems: 'center',
                                boxShadow: '0 2px 8px rgba(0,0,0,0.05)'
                            }}>
                                <div style={{ 
                                    fontSize: '32px', 
                                    marginRight: '15px',
                                    width: '50px',
                                    height: '50px',
                                    background: '#fff',
                                    borderRadius: '50%',
                                    display: 'flex',
                                    alignItems: 'center',
                                    justifyContent: 'center',
                                    boxShadow: '0 2px 4px rgba(0,0,0,0.1)'
                                }}>🏠</div>
                                <div>
                                    <div style={{ fontSize: '11px', textTransform: 'uppercase', color: '#888', marginBottom: '4px', fontWeight: '600' }}>Accommodation</div>
                                    <div style={{ fontWeight: 'bold', fontSize: '16px', color: '#1A2B4C' }}>{pkg.accommodation}</div>
                                </div>
                            </div>
                        )}
                        {pkg.meals && (
                            <div style={{ 
                                background: 'linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%)',
                                border: '2px solid #e9ecef',
                                borderRadius: '12px',
                                padding: '20px',
                                display: 'flex',
                                alignItems: 'center',
                                boxShadow: '0 2px 8px rgba(0,0,0,0.05)'
                            }}>
                                <div style={{ 
                                    fontSize: '32px', 
                                    marginRight: '15px',
                                    width: '50px',
                                    height: '50px',
                                    background: '#fff',
                                    borderRadius: '50%',
                                    display: 'flex',
                                    alignItems: 'center',
                                    justifyContent: 'center',
                                    boxShadow: '0 2px 4px rgba(0,0,0,0.1)'
                                }}>🍽️</div>
                                <div>
                                    <div style={{ fontSize: '11px', textTransform: 'uppercase', color: '#888', marginBottom: '4px', fontWeight: '600' }}>Meals</div>
                                    <div style={{ fontWeight: 'bold', fontSize: '16px', color: '#1A2B4C' }}>{pkg.meals}</div>
                                </div>
                            </div>
                        )}
                        {pkg.best_season && (
                            <div style={{ 
                                background: 'linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%)',
                                border: '2px solid #e9ecef',
                                borderRadius: '12px',
                                padding: '20px',
                                display: 'flex',
                                alignItems: 'center',
                                boxShadow: '0 2px 8px rgba(0,0,0,0.05)'
                            }}>
                                <div style={{ 
                                    fontSize: '32px', 
                                    marginRight: '15px',
                                    width: '50px',
                                    height: '50px',
                                    background: '#fff',
                                    borderRadius: '50%',
                                    display: 'flex',
                                    alignItems: 'center',
                                    justifyContent: 'center',
                                    boxShadow: '0 2px 4px rgba(0,0,0,0.1)'
                                }}>☀️</div>
                                <div>
                                    <div style={{ fontSize: '11px', textTransform: 'uppercase', color: '#888', marginBottom: '4px', fontWeight: '600' }}>Best Season</div>
                                    <div style={{ fontWeight: 'bold', fontSize: '16px', color: '#1A2B4C' }}>{pkg.best_season}</div>
                                </div>
                            </div>
                        )}
                    </div>

                    {/* Highlights */}
                    {pkg.highlight_key && pkg.highlight_key.length > 0 && (
                        <>
                            <h3 style={{ 
                                fontSize: '24px',
                                color: '#1A2B4C',
                                fontWeight: 'bold',
                                borderLeft: '5px solid #D4AF6A',
                                paddingLeft: '20px',
                                marginBottom: '25px',
                                marginTop: '40px',
                                textTransform: 'uppercase',
                                letterSpacing: '0.5px'
                            }}>
                                Trip Highlights
                            </h3>
                            <div style={{ 
                                background: '#fff9e6',
                                border: '2px solid #D4AF6A',
                                borderRadius: '12px',
                                padding: '25px',
                                marginBottom: '40px'
                            }}>
                                <ul style={{ listStyle: 'none', padding: 0, margin: 0 }}>
                                    {pkg.highlight_key.map((point, idx) => (
                                        <li key={idx} style={{ 
                                            position: 'relative',
                                            paddingLeft: '35px',
                                            marginBottom: '12px',
                                            color: '#333',
                                            fontSize: '15px',
                                            lineHeight: '1.6'
                                        }}>
                                            <span style={{ 
                                                position: 'absolute',
                                                left: 0,
                                                top: '2px',
                                                color: '#D4AF6A',
                                                fontSize: '18px',
                                                fontWeight: 'bold'
                                            }}>★</span>
                                            {point}
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        </>
                    )}

                    {/* Overview */}
                    {(pkg.content || pkg.description) && (
                        <>
                            <h3 style={{ 
                                fontSize: '24px',
                                color: '#1A2B4C',
                                fontWeight: 'bold',
                                borderLeft: '5px solid #D4AF6A',
                                paddingLeft: '20px',
                                marginBottom: '25px',
                                marginTop: '40px',
                                textTransform: 'uppercase',
                                letterSpacing: '0.5px'
                            }}>
                                Trip Overview
                            </h3>
                            <div 
                                style={{ 
                                    fontSize: '15px',
                                    color: '#555',
                                    lineHeight: '1.8',
                                    textAlign: 'justify',
                                    marginBottom: '40px'
                                }}
                                dangerouslySetInnerHTML={{ __html: pkg.content || pkg.description }}
                            />
                        </>
                    )}

                    {/* Itinerary */}
                    {pkg.itinerary_data && pkg.itinerary_data.length > 0 && (
                        <>
                            <h3 style={{ 
                                fontSize: '24px',
                                color: '#1A2B4C',
                                fontWeight: 'bold',
                                borderLeft: '5px solid #D4AF6A',
                                paddingLeft: '20px',
                                marginBottom: '25px',
                                marginTop: '40px',
                                textTransform: 'uppercase',
                                letterSpacing: '0.5px'
                            }}>
                                Detailed Itinerary
                            </h3>
                            {pkg.itinerary_data.map((day, index) => (
                                <div key={index} style={{ 
                                    borderLeft: '4px solid #3498db',
                                    marginLeft: '15px',
                                    paddingLeft: '30px',
                                    position: 'relative',
                                    marginBottom: '30px',
                                    pageBreakInside: 'avoid'
                                }}>
                                    <div style={{ 
                                        position: 'absolute',
                                        left: '-12px',
                                        top: '0',
                                        width: '20px',
                                        height: '20px',
                                        background: '#3498db',
                                        border: '4px solid #fff',
                                        borderRadius: '50%',
                                        boxShadow: '0 2px 4px rgba(0,0,0,0.2)'
                                    }}></div>
                                    <div style={{ 
                                        background: 'linear-gradient(135deg, #f0f4f8 0%, #e9ecef 100%)',
                                        padding: '15px 20px',
                                        borderRadius: '8px',
                                        marginBottom: '15px',
                                        border: '2px solid #3498db'
                                    }}>
                                        <h5 style={{ margin: 0, color: '#1A2B4C', fontWeight: 'bold', fontSize: '18px' }}>
                                            {day.name || `Day ${index + 1}`}
                                        </h5>
                                    </div>
                                    <div style={{ paddingLeft: '10px' }}>
                                        <p style={{ marginBottom: '15px', color: '#555', fontSize: '14px', lineHeight: '1.8', whiteSpace: 'pre-wrap' }}>
                                            {day.content}
                                        </p>
                                        {(day.max_elevation || day.duration || day.meals || day.accommodation) && (
                                            <div style={{ 
                                                display: 'flex',
                                                flexWrap: 'wrap',
                                                gap: '20px',
                                                marginTop: '15px',
                                                background: '#fff',
                                                border: '2px solid #e9ecef',
                                                padding: '15px',
                                                borderRadius: '8px'
                                            }}>
                                                {day.max_elevation && (
                                                    <span style={{ fontSize: '13px', color: '#666' }}>
                                                        <strong style={{ color: '#1A2B4C' }}>🏔️ Altitude:</strong> {day.max_elevation}
                                                    </span>
                                                )}
                                                {day.duration && (
                                                    <span style={{ fontSize: '13px', color: '#666' }}>
                                                        <strong style={{ color: '#1A2B4C' }}>⏱️ Duration:</strong> {day.duration}
                                                    </span>
                                                )}
                                                {day.meals && (
                                                    <span style={{ fontSize: '13px', color: '#666' }}>
                                                        <strong style={{ color: '#1A2B4C' }}>🍽️ Meals:</strong> {day.meals}
                                                    </span>
                                                )}
                                                {day.accommodation && (
                                                    <span style={{ fontSize: '13px', color: '#666' }}>
                                                        <strong style={{ color: '#1A2B4C' }}>🏠 Sleep:</strong> {day.accommodation}
                                                    </span>
                                                )}
                                            </div>
                                        )}
                                    </div>
                                </div>
                            ))}
                        </>
                    )}

                    {/* Equipment */}
                    {equipmentCategories.some(cat => cat.data && cat.data.length > 0) && (
                        <>
                            <h3 style={{ 
                                fontSize: '24px',
                                color: '#1A2B4C',
                                fontWeight: 'bold',
                                borderLeft: '5px solid #D4AF6A',
                                paddingLeft: '20px',
                                marginBottom: '25px',
                                marginTop: '40px',
                                textTransform: 'uppercase',
                                letterSpacing: '0.5px'
                            }}>
                                Equipment Checklist
                            </h3>
                            <div style={{ 
                                display: 'grid',
                                gridTemplateColumns: 'repeat(2, 1fr)',
                                gap: '25px'
                            }}>
                                {equipmentCategories.map((cat, catIdx) => (
                                    cat.data && cat.data.length > 0 && (
                                        <div key={catIdx} style={{ 
                                            background: '#fafafa',
                                            padding: '20px',
                                            borderRadius: '12px',
                                            border: '2px solid #eaeaea',
                                            pageBreakInside: 'avoid'
                                        }}>
                                            <h4 style={{ 
                                                fontSize: '18px',
                                                fontWeight: 'bold',
                                                marginBottom: '15px',
                                                color: '#1A2B4C',
                                                display: 'flex',
                                                alignItems: 'center',
                                                borderBottom: '2px solid #D4AF6A',
                                                paddingBottom: '10px'
                                            }}>
                                                <span style={{ marginRight: '10px', fontSize: '24px' }}>{cat.icon}</span>
                                                {cat.label}
                                            </h4>
                                            <ul style={{ listStyle: 'none', padding: 0, margin: 0 }}>
                                                {cat.data.map((item, idx) => (
                                                    <li key={idx} style={{ 
                                                        display: 'flex',
                                                        alignItems: 'flex-start',
                                                        marginBottom: '10px',
                                                        fontSize: '14px',
                                                        lineHeight: '1.5'
                                                    }}>
                                                        <span style={{ 
                                                            color: '#27ae60', 
                                                            marginRight: '10px', 
                                                            marginTop: '2px',
                                                            fontSize: '16px',
                                                            fontWeight: 'bold'
                                                        }}>✓</span>
                                                        {item.content}
                                                    </li>
                                                ))}
                                            </ul>
                                        </div>
                                    )
                                ))}
                            </div>
                        </>
                    )}

                    {/* Includes / Excludes */}
                    {(pkg.included_data?.length > 0 || pkg.excluded_data?.length > 0) && (
                        <>
                            <h3 style={{ 
                                fontSize: '24px',
                                color: '#1A2B4C',
                                fontWeight: 'bold',
                                borderLeft: '5px solid #D4AF6A',
                                paddingLeft: '20px',
                                marginBottom: '25px',
                                marginTop: '40px',
                                textTransform: 'uppercase',
                                letterSpacing: '0.5px'
                            }}>
                                What's Included & Excluded
                            </h3>
                            <div style={{ 
                                display: 'grid',
                                gridTemplateColumns: '1fr 1fr',
                                gap: '25px',
                                marginTop: '30px'
                            }}>
                                {pkg.included_data && pkg.included_data.length > 0 && (
                                    <div style={{ 
                                        borderTop: '5px solid #27ae60',
                                        background: 'linear-gradient(135deg, #f4fbf7 0%, #e8f5e9 100%)',
                                        padding: '25px',
                                        borderRadius: '12px',
                                        border: '2px solid #27ae60'
                                    }}>
                                        <h4 style={{ 
                                            fontSize: '20px',
                                            fontWeight: 'bold',
                                            marginBottom: '20px',
                                            color: '#27ae60',
                                            display: 'flex',
                                            alignItems: 'center'
                                        }}>
                                            <span style={{ fontSize: '24px', marginRight: '10px' }}>✓</span>
                                            Included in Trip
                                        </h4>
                                        <ul style={{ listStyle: 'none', padding: 0, margin: 0 }}>
                                            {pkg.included_data.map((item, idx) => (
                                                <li key={idx} style={{ 
                                                    position: 'relative',
                                                    paddingLeft: '25px',
                                                    marginBottom: '12px',
                                                    fontSize: '14px',
                                                    lineHeight: '1.6'
                                                }}>
                                                    <span style={{ 
                                                        position: 'absolute',
                                                        left: 0,
                                                        top: '2px',
                                                        color: '#27ae60',
                                                        fontWeight: 'bold',
                                                        fontSize: '16px'
                                                    }}>✓</span>
                                                    {item.content}
                                                </li>
                                            ))}
                                        </ul>
                                    </div>
                                )}
                                {pkg.excluded_data && pkg.excluded_data.length > 0 && (
                                    <div style={{ 
                                        borderTop: '5px solid #e74c3c',
                                        background: 'linear-gradient(135deg, #fcf4f4 0%, #ffebee 100%)',
                                        padding: '25px',
                                        borderRadius: '12px',
                                        border: '2px solid #e74c3c'
                                    }}>
                                        <h4 style={{ 
                                            fontSize: '20px',
                                            fontWeight: 'bold',
                                            marginBottom: '20px',
                                            color: '#e74c3c',
                                            display: 'flex',
                                            alignItems: 'center'
                                        }}>
                                            <span style={{ fontSize: '24px', marginRight: '10px' }}>✗</span>
                                            Not Included
                                        </h4>
                                        <ul style={{ listStyle: 'none', padding: 0, margin: 0 }}>
                                            {pkg.excluded_data.map((item, idx) => (
                                                <li key={idx} style={{ 
                                                    position: 'relative',
                                                    paddingLeft: '25px',
                                                    marginBottom: '12px',
                                                    fontSize: '14px',
                                                    lineHeight: '1.6'
                                                }}>
                                                    <span style={{ 
                                                        position: 'absolute',
                                                        left: 0,
                                                        top: '2px',
                                                        color: '#e74c3c',
                                                        fontWeight: 'bold',
                                                        fontSize: '16px'
                                                    }}>✗</span>
                                                    {item.content}
                                                </li>
                                            ))}
                                        </ul>
                                    </div>
                                )}
                            </div>
                        </>
                    )}

              
                    {pkg.faqs && pkg.faqs.length > 0 && (
                        <>
                            <h3 style={{ 
                                fontSize: '24px',
                                color: '#1A2B4C',
                                fontWeight: 'bold',
                                borderLeft: '5px solid #D4AF6A',
                                paddingLeft: '20px',
                                marginBottom: '25px',
                                marginTop: '40px',
                                textTransform: 'uppercase',
                                letterSpacing: '0.5px'
                            }}>
                                Frequently Asked Questions
                            </h3>
                            {pkg.faqs.map((faq, index) => (
                                <div key={index} style={{ 
                                    marginBottom: '15px',
                                    border: '2px solid #e9ecef',
                                    borderRadius: '12px',
                                    overflow: 'hidden',
                                    pageBreakInside: 'avoid'
                                }}>
                                    <div style={{ 
                                        background: 'linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%)',
                                        padding: '15px 20px',
                                        fontWeight: 'bold',
                                        color: '#1A2B4C',
                                        fontSize: '15px',
                                        borderBottom: '2px solid #D4AF6A'
                                    }}>
                                        <span style={{ color: '#D4AF6A', marginRight: '10px', fontSize: '18px' }}>Q:</span>
                                        {faq.label || faq.question}
                                    </div>
                                    <div style={{ 
                                        padding: '15px 20px',
                                        color: '#555',
                                        fontSize: '14px',
                                        lineHeight: '1.6',
                                        background: '#fff'
                                    }}>
                                        <span style={{ color: '#3498db', marginRight: '10px', fontWeight: 'bold' }}>A:</span>
                                        {faq.detail || faq.answer}
                                    </div>
                                </div>
                            ))}
                        </>
                    )}

                  
                    <div style={{ 
                        marginTop: '60px',
                        borderTop: '4px solid #1A2B4C',
                        paddingTop: '40px',
                        background: 'linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%)',
                        padding: '40px',
                        borderRadius: '12px'
                    }}>
                
                        <div style={{ 
                            display: 'flex',
                            justifyContent: 'space-between',
                            alignItems: 'flex-start',
                            marginBottom: '30px',
                            paddingBottom: '30px',
                            borderBottom: '2px solid #ddd'
                        }}>
                            <div style={{ flex: '1' }}>
                                {setting.logo_url && (
                                    <img 
                                        src={setting.logo_url} 
                                        alt="Logo"
                                        crossOrigin="anonymous"
                                        style={{ 
                                            maxWidth: '150px', 
                                            marginBottom: '15px',
                                            borderRadius: '8px'
                                        }}
                                    />
                                )}
                                <h3 style={{ 
                                    marginTop: '0',
                                    marginBottom: '10px',
                                    fontSize: '24px',
                                    color: '#1A2B4C',
                                    fontWeight: 'bold'
                                }}>
                                    {setting.system_name || 'SP Travel and Tours'}
                                </h3>
                                <p style={{ 
                                    fontSize: '14px',
                                    color: '#666',
                                    lineHeight: '1.6',
                                    margin: 0,
                                    maxWidth: '400px'
                                }}>
                                    Your trusted partner for unforgettable adventures in Nepal. We provide world-class experiences with local expertise.
                                </p>
                            </div>
                            <div style={{ 
                                textAlign: 'right',
                                fontSize: '14px',
                                color: '#555',
                                lineHeight: '1.8'
                            }}>
                                {setting.address && (
                                    <div style={{ marginBottom: '10px', display: 'flex', alignItems: 'flex-start', justifyContent: 'flex-end' }}>
                                        <span style={{ marginRight: '10px', fontSize: '18px' }}>📍</span>
                                        <span>{setting.address}</span>
                                    </div>
                                )}
                                {setting.email && (
                                    <div style={{ marginBottom: '10px', display: 'flex', alignItems: 'center', justifyContent: 'flex-end' }}>
                                        <span style={{ marginRight: '10px', fontSize: '18px' }}>✉️</span>
                                        <span>{setting.email}</span>
                                    </div>
                                )}
                                {setting.phone && (
                                    <div style={{ marginBottom: '10px', display: 'flex', alignItems: 'center', justifyContent: 'flex-end' }}>
                                        <span style={{ marginRight: '10px', fontSize: '18px' }}>📞</span>
                                        <span>{setting.phone}</span>
                                    </div>
                                )}
                            </div>
                        </div>

              
                        <div style={{ 
                            background: '#fff',
                            border: '2px solid #D4AF6A',
                            borderRadius: '8px',
                            padding: '20px',
                            marginBottom: '25px'
                        }}>
                            <h4 style={{ 
                                fontSize: '16px',
                                color: '#1A2B4C',
                                fontWeight: 'bold',
                                marginBottom: '15px',
                                margin: '0 0 15px 0'
                            }}>
                                ℹ️ Important Information
                            </h4>
                            <ul style={{ 
                                margin: 0,
                                paddingLeft: '20px',
                                fontSize: '13px',
                                color: '#666',
                                lineHeight: '1.8'
                            }}>
                                <li>This itinerary is subject to change based on weather conditions and group requirements.</li>
                                <li>Travel insurance is mandatory for all participants.</li>
                                <li>Please ensure you have the necessary visas and permits before travel.</li>
                                <li>For cancellations, please refer to our cancellation policy.</li>
                            </ul>
                        </div>

                      
                        <div style={{ 
                            textAlign: 'center',
                            paddingTop: '20px',
                            borderTop: '2px solid #ddd'
                        }}>
                            <p style={{ 
                                fontSize: '13px',
                                color: '#888',
                                margin: '0 0 10px 0'
                            }}>
                                For more information, visit us at: <strong style={{ color: '#1A2B4C' }}>www.sptravel.com</strong>
                            </p>
                            <p style={{ 
                                fontSize: '12px',
                                color: '#999',
                                margin: 0
                            }}>
                                © {new Date().getFullYear()} {setting.system_name || 'SP Travel and Tours'}. All Rights Reserved. | This is a computer-generated document.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}