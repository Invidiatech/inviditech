import React, { useState } from 'react';
const Contact = ({ isDarkMode }) => {
    const [formData, setFormData] = useState({
        name: '',
        email: '',
        subject: '',
        message: '',
        privacy: false
    });
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [submitStatus, setSubmitStatus] = useState(null);

    const handleInputChange = (e) => {
        const { name, value, type, checked } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: type === 'checkbox' ? checked : value
        }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsSubmitting(true);
        setSubmitStatus(null);

        try {
            const response = await fetch('/contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(formData)
            });

            if (response.ok) {
                setSubmitStatus('success');
                setFormData({
                    name: '',
                    email: '',
                    subject: '',
                    message: '',
                    privacy: false
                });
            } else {
                setSubmitStatus('error');
            }
        } catch (error) {
            console.error('Error submitting form:', error);
            setSubmitStatus('error');
        } finally {
            setIsSubmitting(false);
        }
    };

    const services = [
        {
            title: "Web Development",
            description: "Custom web applications using Laravel, React, Vue.js, and modern technologies",
            icon: "fas fa-laptop-code",
            color: "text-blue-400"
        },
        {
            title: "API Development",
            description: "RESTful APIs, GraphQL endpoints, and microservices architecture",
            icon: "fas fa-code-branch",
            color: "text-green-400"
        },
        {
            title: "Database Design",
            description: "MySQL, PostgreSQL database design, optimization, and migration services",
            icon: "fas fa-database",
            color: "text-purple-400"
        },
        {
            title: "Cloud Deployment",
            description: "AWS, DigitalOcean, and other cloud platform deployment and management",
            icon: "fas fa-cloud",
            color: "text-indigo-400"
        },
        {
            title: "Technical Writing",
            description: "Documentation, tutorials, and technical content creation",
            icon: "fas fa-pencil-alt",
            color: "text-yellow-400"
        },
        {
            title: "Code Review",
            description: "Code quality assessment, optimization, and best practices consultation",
            icon: "fas fa-search",
            color: "text-red-400"
        }
    ];

    const contactMethods = [
        {
            title: "Email",
            value: "sardarnawaz122@gmail.com",
            icon: "fas fa-envelope",
            color: "bg-blue-500",
            link: "mailto:sardarnawaz122@gmail.com"
        },
        {
            title: "LinkedIn",
            value: "linkedin.com/in/muhammad-nawaz",
            icon: "fab fa-linkedin-in",
            color: "bg-blue-600",
            link: "https://www.linkedin.com/in/muhammad-nawaz-43a354201/"
        },
        {
            title: "GitHub",
            value: "github.com/nawazfdev",
            icon: "fab fa-github",
            color: "bg-gray-800",
            link: "https://github.com/nawazfdev"
        },
        {
            title: "Response Time",
            value: "Within 24 hours",
            icon: "fas fa-clock",
            color: "bg-green-500",
            link: null
        }
    ];

    return (
        <div className={`min-h-screen ${isDarkMode ? 'bg-gray-900' : 'bg-gray-50'}`}>
            {/* Hero Section */}
            <section className={`relative py-24 px-4 sm:px-6 lg:px-8 overflow-hidden ${
                isDarkMode 
                    ? 'bg-gradient-to-br from-gray-900 via-indigo-900 to-purple-900' 
                    : 'bg-gradient-to-br from-indigo-50 via-white to-purple-50'
            }`}>
                {/* Background Elements */}
                <div className="absolute inset-0 opacity-10">
                    <div className="absolute top-20 left-10 w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></div>
                    <div className="absolute top-40 right-20 w-1 h-1 bg-purple-500 rounded-full animate-ping"></div>
                    <div className="absolute bottom-20 left-1/4 w-1.5 h-1.5 bg-indigo-400 rounded-full animate-pulse"></div>
                </div>

                <div className="max-w-4xl mx-auto text-center relative z-10">
                    <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full border mb-6">
                        <div className="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></div>
                        <span className={`text-sm font-medium ${
                            isDarkMode ? 'text-gray-300' : 'text-gray-600'
                        }`}>
                            Get In Touch
                        </span>
                    </div>

                    <h1 className={`text-5xl md:text-6xl font-bold mb-6 bg-gradient-to-r ${
                        isDarkMode 
                            ? 'from-white to-gray-400' 
                            : 'from-gray-900 to-gray-600'
                    } bg-clip-text text-transparent`}>
                        Let's Build Something
                        <span className="block text-indigo-400">Amazing Together</span>
                    </h1>
                    <p className={`text-xl mb-8 max-w-2xl mx-auto leading-relaxed ${
                        isDarkMode ? 'text-gray-300' : 'text-gray-600'
                    }`}>
                        Ready to turn your ideas into reality? I'm here to help you create exceptional digital experiences that drive results.
                    </p>
                </div>
            </section>

            {/* Services Section */}
            <section className={`py-24 px-4 sm:px-6 lg:px-8 ${isDarkMode ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <div className="max-w-7xl mx-auto">
                    <div className="text-center mb-20">
                        <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${
                            isDarkMode ? 'text-white' : 'text-gray-900'
                        }`}>
                            Services I Offer
                        </h2>
                        <p className={`text-xl max-w-2xl mx-auto ${
                            isDarkMode ? 'text-gray-300' : 'text-gray-600'
                        }`}>
                            Comprehensive full-stack solutions tailored to your specific needs
                        </p>
                    </div>

                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {services.map((service, index) => (
                            <div
                                key={index}
                                className={`group relative rounded-2xl p-8 backdrop-blur-lg border transition-all duration-500 transform hover:-translate-y-2 ${
                                    isDarkMode 
                                        ? 'bg-gray-800/40 border-gray-700 hover:border-indigo-400' 
                                        : 'bg-white/70 border-gray-200 hover:border-indigo-400'
                                }`}
                            >
                                {/* Icon */}
                                <div className={`w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300`}>
                                    <i className={`${service.icon} text-white text-2xl`}></i>
                                </div>

                                {/* Content */}
                                <h3 className={`text-xl font-semibold mb-4 ${
                                    isDarkMode ? 'text-white' : 'text-gray-900'
                                }`}>
                                    {service.title}
                                </h3>
                                <p className={`text-sm leading-relaxed ${
                                    isDarkMode ? 'text-gray-300' : 'text-gray-600'
                                }`}>
                                    {service.description}
                                </p>

                                {/* Hover Effect */}
                                <div className="absolute inset-0 rounded-2xl bg-gradient-to-br from-indigo-500/5 to-purple-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Contact Form Section */}
            <section className={`py-24 px-4 sm:px-6 lg:px-8 ${isDarkMode ? 'bg-gray-800' : 'bg-white'}`}>
                <div className="max-w-4xl mx-auto">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${
                            isDarkMode ? 'text-white' : 'text-gray-900'
                        }`}>
                            Start Your Project
                        </h2>
                        <p className={`text-xl max-w-2xl mx-auto ${
                            isDarkMode ? 'text-gray-300' : 'text-gray-600'
                        }`}>
                            Have a project in mind? Let's discuss how I can help bring it to life.
                        </p>
                    </div>

                    <div className={`rounded-2xl p-8 backdrop-blur-lg border ${
                        isDarkMode 
                            ? 'bg-gray-800/40 border-gray-700' 
                            : 'bg-white/70 border-gray-200'
                    }`}>
                        <form onSubmit={handleSubmit} className="space-y-8">
                            <div className="grid md:grid-cols-2 gap-8">
                                <div className="space-y-2">
                                    <label htmlFor="name" className={`block text-sm font-medium ${
                                        isDarkMode ? 'text-gray-300' : 'text-gray-700'
                                    }`}>
                                        Full Name *
                                    </label>
                                    <div className="relative">
                                        <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i className="fas fa-user text-gray-400"></i>
                                        </div>
                                        <input
                                            type="text"
                                            id="name"
                                            name="name"
                                            value={formData.name}
                                            onChange={handleInputChange}
                                            required
                                            className={`w-full pl-10 pr-4 py-4 rounded-xl border transition-all duration-300 ${
                                                isDarkMode
                                                    ? 'bg-gray-800/50 border-gray-600 text-white placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20'
                                                    : 'bg-white/50 border-gray-300 text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20'
                                            }`}
                                            placeholder="Your full name"
                                        />
                                    </div>
                                </div>
                                <div className="space-y-2">
                                    <label htmlFor="email" className={`block text-sm font-medium ${
                                        isDarkMode ? 'text-gray-300' : 'text-gray-700'
                                    }`}>
                                        Email Address *
                                    </label>
                                    <div className="relative">
                                        <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i className="fas fa-envelope text-gray-400"></i>
                                        </div>
                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            value={formData.email}
                                            onChange={handleInputChange}
                                            required
                                            className={`w-full pl-10 pr-4 py-4 rounded-xl border transition-all duration-300 ${
                                                isDarkMode
                                                    ? 'bg-gray-800/50 border-gray-600 text-white placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20'
                                                    : 'bg-white/50 border-gray-300 text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20'
                                            }`}
                                            placeholder="your.email@example.com"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div className="space-y-2">
                                <label htmlFor="subject" className={`block text-sm font-medium ${
                                    isDarkMode ? 'text-gray-300' : 'text-gray-700'
                                }`}>
                                    Project Type *
                                </label>
                                <div className="relative">
                                    <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i className="fas fa-tag text-gray-400"></i>
                                    </div>
                                    <select
                                        id="subject"
                                        name="subject"
                                        value={formData.subject}
                                        onChange={handleInputChange}
                                        required
                                        className={`w-full pl-10 pr-4 py-4 rounded-xl border transition-all duration-300 appearance-none ${
                                            isDarkMode
                                                ? 'bg-gray-800/50 border-gray-600 text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20'
                                                : 'bg-white/50 border-gray-300 text-gray-900 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20'
                                        }`}
                                    >
                                        <option value="">Select a service or inquiry type</option>
                                        <option value="Web Development">Web Development</option>
                                        <option value="API Development">API Development</option>
                                        <option value="Database Design">Database Design</option>
                                        <option value="Cloud Deployment">Cloud Deployment</option>
                                        <option value="Technical Writing">Technical Writing</option>
                                        <option value="Code Review">Code Review</option>
                                        <option value="Consultation">General Consultation</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <div className="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i className="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <div className="space-y-2">
                                <label htmlFor="message" className={`block text-sm font-medium ${
                                    isDarkMode ? 'text-gray-300' : 'text-gray-700'
                                }`}>
                                    Project Details *
                                </label>
                                <div className="relative">
                                    <div className="absolute top-4 left-3">
                                        <i className="fas fa-comment text-gray-400"></i>
                                    </div>
                                    <textarea
                                        id="message"
                                        name="message"
                                        value={formData.message}
                                        onChange={handleInputChange}
                                        required
                                        rows={6}
                                        className={`w-full pl-10 pr-4 py-4 rounded-xl border transition-all duration-300 resize-none ${
                                            isDarkMode
                                                ? 'bg-gray-800/50 border-gray-600 text-white placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20'
                                                : 'bg-white/50 border-gray-300 text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20'
                                        }`}
                                        placeholder="Tell me about your project, requirements, timeline, and any specific challenges you're facing..."
                                    />
                                </div>
                            </div>

                            <div className="flex items-start space-x-3">
                                <input
                                    type="checkbox"
                                    id="privacy"
                                    name="privacy"
                                    checked={formData.privacy}
                                    onChange={handleInputChange}
                                    required
                                    className={`mt-1 h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 ${
                                        isDarkMode ? 'bg-gray-800 border-gray-600' : 'bg-white'
                                    }`}
                                />
                                <label htmlFor="privacy" className={`text-sm ${
                                    isDarkMode ? 'text-gray-300' : 'text-gray-700'
                                }`}>
                                    I agree to the privacy policy and consent to being contacted regarding my inquiry. *
                                </label>
                            </div>

                            {/* Status Messages */}
                            {submitStatus === 'success' && (
                                <div className={`p-4 rounded-xl border ${
                                    isDarkMode 
                                        ? 'bg-green-900/20 border-green-800 text-green-300' 
                                        : 'bg-green-50 border-green-200 text-green-700'
                                }`}>
                                    <div className="flex items-center gap-3">
                                        <i className="fas fa-check-circle text-green-500"></i>
                                        <div>
                                            <strong>Success!</strong> Your message has been sent. I'll get back to you within 24 hours.
                                        </div>
                                    </div>
                                </div>
                            )}

                            {submitStatus === 'error' && (
                                <div className={`p-4 rounded-xl border ${
                                    isDarkMode 
                                        ? 'bg-red-900/20 border-red-800 text-red-300' 
                                        : 'bg-red-50 border-red-200 text-red-700'
                                }`}>
                                    <div className="flex items-center gap-3">
                                        <i className="fas fa-exclamation-circle text-red-500"></i>
                                        <div>
                                            <strong>Error!</strong> There was a problem sending your message. Please try again or contact me directly.
                                        </div>
                                    </div>
                                </div>
                            )}

                            <button
                                type="submit"
                                disabled={isSubmitting}
                                className={`w-full py-4 px-6 rounded-xl font-semibold text-white transition-all duration-300 flex items-center justify-center gap-3 ${
                                    isSubmitting
                                        ? 'bg-gray-400 cursor-not-allowed'
                                        : 'bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 shadow-lg hover:shadow-xl'
                                }`}
                            >
                                {isSubmitting ? (
                                    <>
                                        <i className="fas fa-spinner fa-spin"></i>
                                        Sending Message...
                                    </>
                                ) : (
                                    <>
                                        <i className="fas fa-paper-plane"></i>
                                        Send Message
                                    </>
                                )}
                            </button>
                        </form>
                    </div>
                </div>
            </section>

            {/* Contact Info Section */}
            <section className={`py-24 px-4 sm:px-6 lg:px-8 ${isDarkMode ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <div className="max-w-4xl mx-auto">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${
                            isDarkMode ? 'text-white' : 'text-gray-900'
                        }`}>
                            Other Ways to Connect
                        </h2>
                        <p className={`text-xl max-w-2xl mx-auto ${
                            isDarkMode ? 'text-gray-300' : 'text-gray-600'
                        }`}>
                            Prefer a different method? Here are all the ways you can reach me.
                        </p>
                    </div>

                    <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                        {contactMethods.map((method, index) => (
                            <div
                                key={index}
                                className={`group relative rounded-2xl p-6 backdrop-blur-lg border transition-all duration-300 transform hover:-translate-y-2 ${
                                    isDarkMode 
                                        ? 'bg-gray-800/40 border-gray-700 hover:border-indigo-400' 
                                        : 'bg-white/70 border-gray-200 hover:border-indigo-400'
                                }`}
                            >
                                <div className={`w-12 h-12 ${method.color} rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300`}>
                                    <i className={`${method.icon} text-white`}></i>
                                </div>
                                <h3 className={`text-lg font-semibold mb-2 ${
                                    isDarkMode ? 'text-white' : 'text-gray-900'
                                }`}>
                                    {method.title}
                                </h3>
                                {method.link ? (
                                    <a 
                                        href={method.link}
                                        target={method.link.startsWith('http') ? '_blank' : '_self'}
                                        rel={method.link.startsWith('http') ? 'noopener noreferrer' : ''}
                                        className={`text-sm transition-colors ${
                                            isDarkMode 
                                                ? 'text-gray-300 hover:text-indigo-400' 
                                                : 'text-gray-600 hover:text-indigo-600'
                                        }`}
                                    >
                                        {method.value}
                                    </a>
                                ) : (
                                    <p className={`text-sm ${
                                        isDarkMode ? 'text-gray-300' : 'text-gray-600'
                                    }`}>
                                        {method.value}
                                    </p>
                                )}
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        </div>
    );
};

export default Contact;