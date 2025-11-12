import React from 'react';

const Services = () => {
    const services = [
        {
            title: 'Web Development',
            description: 'Custom web applications built with modern technologies like React, Laravel, and Node.js.',
            icon: '🌐',
            features: ['Responsive Design', 'SEO Optimized', 'Fast Performance', 'Secure & Scalable']
        },
        {
            title: 'Mobile App Development',
            description: 'Native and cross-platform mobile applications for iOS and Android.',
            icon: '📱',
            features: ['Native iOS/Android', 'React Native', 'Flutter', 'App Store Optimization']
        },
        {
            title: 'E-commerce Solutions',
            description: 'Complete e-commerce platforms with payment integration and inventory management.',
            icon: '🛒',
            features: ['Payment Gateway', 'Inventory Management', 'Order Tracking', 'Analytics Dashboard']
        },
        {
            title: 'Digital Marketing',
            description: 'SEO, social media marketing, and digital advertising to grow your online presence.',
            icon: '📈',
            features: ['SEO Optimization', 'Social Media', 'PPC Campaigns', 'Content Marketing']
        },
        {
            title: 'UI/UX Design',
            description: 'Beautiful, user-friendly designs that enhance user experience and engagement.',
            icon: '🎨',
            features: ['User Research', 'Wireframing', 'Prototyping', 'Visual Design']
        },
        {
            title: 'Cloud Solutions',
            description: 'Cloud infrastructure setup, migration, and management for scalable applications.',
            icon: '☁️',
            features: ['AWS/Azure/GCP', 'DevOps', 'CI/CD Pipeline', 'Monitoring & Support']
        }
    ];

    return (
        <div className="bg-white">
            {/* Hero Section */}
            <section className="bg-gradient-to-br from-blue-900 to-purple-900 text-white py-20">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h1 className="text-4xl md:text-5xl font-bold mb-6">Our Services</h1>
                    <p className="text-xl text-blue-100 max-w-3xl mx-auto">
                        We offer comprehensive technology solutions to help your business thrive in the digital world.
                    </p>
                </div>
            </section>

            {/* Services Grid */}
            <section className="py-20">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {services.map((service, index) => (
                            <div key={index} className="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-8 border border-gray-100">
                                <div className="text-4xl mb-4">{service.icon}</div>
                                <h3 className="text-2xl font-bold text-gray-900 mb-4">{service.title}</h3>
                                <p className="text-gray-600 mb-6">{service.description}</p>
                                <ul className="space-y-2">
                                    {service.features.map((feature, featureIndex) => (
                                        <li key={featureIndex} className="flex items-center text-sm text-gray-600">
                                            <svg className="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                                            </svg>
                                            {feature}
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section className="bg-gray-50 py-16">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 className="text-3xl font-bold text-gray-900 mb-4">Ready to Get Started?</h2>
                    <p className="text-xl text-gray-600 mb-8">
                        Let's discuss your project and find the perfect solution for your needs.
                    </p>
                    <a
                        href="/contact"
                        className="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 inline-block"
                    >
                        Contact Us Today
                    </a>
                </div>
            </section>
        </div>
    );
};

export default Services;
