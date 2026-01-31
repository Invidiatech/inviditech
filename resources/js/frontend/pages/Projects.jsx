import React, { useState, useEffect } from 'react';

const Projects = ({ isDarkMode }) => {
    const [countdown, setCountdown] = useState({ days: 0, hours: 0, minutes: 0, seconds: 0 });

    // Set launch date (you can change this)
    const launchDate = new Date('2024-03-01').getTime();

    useEffect(() => {
        const timer = setInterval(() => {
            const now = new Date().getTime();
            const distance = launchDate - now;

            if (distance > 0) {
                setCountdown({
                    days: Math.floor(distance / (1000 * 60 * 60 * 24)),
                    hours: Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
                    minutes: Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)),
                    seconds: Math.floor((distance % (1000 * 60)) / 1000)
                });
            }
        }, 1000);

        return () => clearInterval(timer);
    }, [launchDate]);

    return (
        <div className={`min-h-screen flex items-center justify-center ${isDarkMode ? 'bg-gray-950' : 'bg-gray-50'} relative overflow-hidden`}>
            {/* Animated Background */}
            <div className="absolute inset-0 overflow-hidden">
                {/* Gradient Orbs */}
                <div className="absolute top-1/4 left-1/4 w-96 h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                <div className="absolute top-1/3 right-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
                <div className="absolute bottom-1/4 left-1/3 w-96 h-96 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
                
                {/* Floating Dots Pattern */}
                <div className={`absolute inset-0 ${isDarkMode ? 'opacity-10' : 'opacity-5'}`}>
                    <div className="absolute top-20 left-20 w-2 h-2 bg-indigo-500 rounded-full animate-float"></div>
                    <div className="absolute top-40 right-32 w-3 h-3 bg-purple-500 rounded-full animate-float animation-delay-1000"></div>
                    <div className="absolute bottom-20 left-1/3 w-2 h-2 bg-pink-500 rounded-full animate-float animation-delay-2000"></div>
                    <div className="absolute bottom-40 right-20 w-3 h-3 bg-cyan-500 rounded-full animate-float animation-delay-3000"></div>
                    <div className="absolute top-1/2 left-10 w-2 h-2 bg-indigo-400 rounded-full animate-float animation-delay-4000"></div>
                    <div className="absolute top-1/3 right-1/4 w-2 h-2 bg-purple-400 rounded-full animate-float animation-delay-5000"></div>
                </div>
            </div>

            {/* Main Content */}
            <div className="relative z-10 max-w-5xl mx-auto px-6 text-center">
                {/* Icon/Logo */}
                <div className="mb-8 inline-block">
                    <div className="relative">
                        <div className={`w-24 h-24 mx-auto rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-2xl transform hover:scale-110 transition-all duration-300 ${isDarkMode ? 'shadow-indigo-500/50' : 'shadow-indigo-500/30'}`}>
                            <i className="fas fa-rocket text-4xl text-white animate-bounce-slow"></i>
                        </div>
                        {/* Pulse Ring */}
                        <div className="absolute inset-0 rounded-2xl bg-indigo-500 opacity-20 animate-ping"></div>
                    </div>
                </div>

                {/* Badge */}
                <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-indigo-500/10 to-purple-500/10 border border-indigo-500/20 mb-6">
                    <span className="relative flex h-3 w-3">
                        <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span className="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                    </span>
                    <span className={`text-sm font-semibold ${isDarkMode ? 'text-indigo-300' : 'text-indigo-600'}`}>
                        Under Development
                    </span>
                </div>

                {/* Main Heading */}
                <h1 className={`text-5xl md:text-7xl font-bold mb-6 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                    Something <span className="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 bg-clip-text text-transparent">Amazing</span> is Coming
                </h1>

                {/* Description */}
                <p className={`text-xl md:text-2xl mb-12 max-w-3xl mx-auto ${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                    We're crafting an extraordinary portfolio showcase to present our best work. Stay tuned for the reveal!
                </p>

                {/* Countdown Timer */}
                <div className="grid grid-cols-4 gap-4 md:gap-8 max-w-2xl mx-auto mb-12">
                    {[
                        { label: 'Days', value: countdown.days },
                        { label: 'Hours', value: countdown.hours },
                        { label: 'Minutes', value: countdown.minutes },
                        { label: 'Seconds', value: countdown.seconds }
                    ].map((item, index) => (
                        <div key={index} className={`p-4 md:p-6 rounded-2xl ${isDarkMode ? 'bg-gray-900/80 border border-gray-800' : 'bg-white border border-gray-200'} shadow-xl backdrop-blur-lg transform hover:scale-105 transition-all duration-300`}>
                            <div className={`text-3xl md:text-5xl font-bold bg-gradient-to-br from-indigo-500 to-purple-600 bg-clip-text text-transparent mb-2`}>
                                {String(item.value).padStart(2, '0')}
                            </div>
                            <div className={`text-xs md:text-sm uppercase tracking-wider ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
                                {item.label}
                            </div>
                        </div>
                    ))}
                </div>

                {/* Features Preview */}
                <div className="grid md:grid-cols-3 gap-6 mb-12 max-w-4xl mx-auto">
                    {[
                        { icon: 'fas fa-briefcase', title: 'Real Projects', description: 'Showcasing actual client work' },
                        { icon: 'fas fa-chart-line', title: 'Case Studies', description: 'Detailed project breakdowns' },
                        { icon: 'fas fa-code', title: 'Tech Stack', description: 'Technologies we master' }
                    ].map((feature, index) => (
                        <div key={index} className={`p-6 rounded-xl ${isDarkMode ? 'bg-gray-900/50 border border-gray-800' : 'bg-white/50 border border-gray-200'} backdrop-blur-lg transform hover:scale-105 transition-all duration-300`}>
                            <div className={`w-12 h-12 mx-auto mb-4 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center ${isDarkMode ? 'shadow-indigo-500/50' : 'shadow-indigo-500/30'} shadow-lg`}>
                                <i className={`${feature.icon} text-white text-lg`}></i>
                            </div>
                            <h3 className={`font-bold text-lg mb-2 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                {feature.title}
                            </h3>
                            <p className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                                {feature.description}
                            </p>
                        </div>
                    ))}
                </div>

                {/* CTA Buttons */}
                <div className="flex flex-wrap gap-4 justify-center">
                    <a
                        href="/contact"
                        className="group px-8 py-4 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 inline-flex items-center gap-2"
                    >
                        Get in Touch
                        <i className="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a
                        href="/services"
                        className={`px-8 py-4 rounded-xl font-semibold border-2 ${isDarkMode ? 'border-gray-700 text-gray-200 hover:border-gray-600' : 'border-gray-300 text-gray-700 hover:border-gray-400'} transform hover:scale-105 transition-all duration-300 inline-flex items-center gap-2`}
                    >
                        View Services
                        <i className="fas fa-arrow-right"></i>
                    </a>
                </div>

                {/* Social Links */}
                <div className="mt-16 flex justify-center gap-4">
                    <a href="https://github.com/nawazfdev" target="_blank" rel="noopener noreferrer" 
                       className={`w-12 h-12 rounded-full ${isDarkMode ? 'bg-gray-900 hover:bg-gray-800' : 'bg-white hover:bg-gray-50'} border ${isDarkMode ? 'border-gray-800' : 'border-gray-200'} flex items-center justify-center transition-all hover:scale-110 shadow-lg`}>
                        <i className="fab fa-github text-xl"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/muhammad-nawaz-43a354201/" target="_blank" rel="noopener noreferrer"
                       className={`w-12 h-12 rounded-full ${isDarkMode ? 'bg-gray-900 hover:bg-gray-800' : 'bg-white hover:bg-gray-50'} border ${isDarkMode ? 'border-gray-800' : 'border-gray-200'} flex items-center justify-center transition-all hover:scale-110 shadow-lg`}>
                        <i className="fab fa-linkedin-in text-xl text-blue-600"></i>
                    </a>
                    <a href="https://www.facebook.com/Muhammad.Nawaz.Dev/" target="_blank" rel="noopener noreferrer"
                       className={`w-12 h-12 rounded-full ${isDarkMode ? 'bg-gray-900 hover:bg-gray-800' : 'bg-white hover:bg-gray-50'} border ${isDarkMode ? 'border-gray-800' : 'border-gray-200'} flex items-center justify-center transition-all hover:scale-110 shadow-lg`}>
                        <i className="fab fa-facebook-f text-xl text-blue-500"></i>
                    </a>
                </div>

                {/* Bottom Text */}
                <p className={`mt-12 text-sm ${isDarkMode ? 'text-gray-500' : 'text-gray-400'}`}>
                    Meanwhile, check out our <a href="/case-studies" className="text-indigo-500 hover:text-indigo-400 font-semibold">case studies</a> and <a href="/services" className="text-indigo-500 hover:text-indigo-400 font-semibold">services</a>
                </p>
            </div>

            {/* Custom Animations */}
            <style>{`
                @keyframes blob {
                    0%, 100% { transform: translate(0, 0) scale(1); }
                    25% { transform: translate(20px, -50px) scale(1.1); }
                    50% { transform: translate(-20px, 20px) scale(0.9); }
                    75% { transform: translate(50px, 50px) scale(1.05); }
                }
                
                @keyframes float {
                    0%, 100% { transform: translateY(0px); }
                    50% { transform: translateY(-20px); }
                }
                
                @keyframes bounce-slow {
                    0%, 100% { transform: translateY(0); }
                    50% { transform: translateY(-10px); }
                }
                
                .animate-blob {
                    animation: blob 7s infinite;
                }
                
                .animate-float {
                    animation: float 3s ease-in-out infinite;
                }
                
                .animate-bounce-slow {
                    animation: bounce-slow 2s ease-in-out infinite;
                }
                
                .animation-delay-1000 {
                    animation-delay: 1s;
                }
                
                .animation-delay-2000 {
                    animation-delay: 2s;
                }
                
                .animation-delay-3000 {
                    animation-delay: 3s;
                }
                
                .animation-delay-4000 {
                    animation-delay: 4s;
                }
                
                .animation-delay-5000 {
                    animation-delay: 5s;
                }
            `}</style>
        </div>
    );
};

export default Projects;
