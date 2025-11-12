import React from 'react';

const Home = ({ isDarkMode, blogData }) => {
    const testimonials = [
        {
            id: 1,
            name: "Emma Thompson",
            role: "Creative Director, BrightStudio",
            image: "https://randomuser.me/api/portraits/women/44.jpg",
            content: "Working with Muhammad was an absolute pleasure. His attention to detail and design expertise truly elevated our brand identity.",
        },
        {
            id: 2,
            name: "David Miller",
            role: "CTO, NexaTech",
            image: "https://randomuser.me/api/portraits/men/32.jpg",
            content: "The website was delivered ahead of schedule with flawless functionality. Excellent communication and top-notch technical skills!",
        },
        {
            id: 3,
            name: "Sophia Williams",
            role: "Marketing Head, Visionary Co.",
            image: "https://randomuser.me/api/portraits/women/68.jpg",
            content: "I'm incredibly impressed with the professionalism and creativity. The final product exceeded all expectations!",
        },
    ];

    const getCategoryColor = (categoryName) => {
        const colors = {
            'Laravel': 'from-indigo-500 to-purple-600',
            'React': 'from-blue-500 to-cyan-600',
            'JavaScript': 'from-yellow-500 to-orange-600',
            'AI': 'from-purple-500 to-pink-600',
            'Performance': 'from-emerald-500 to-teal-600',
            'Architecture': 'from-orange-500 to-red-600',
            'Vue.js': 'from-green-500 to-emerald-600',
            'Node.js': 'from-green-600 to-green-800',
            'PHP': 'from-purple-600 to-indigo-800',
            'Database': 'from-blue-600 to-purple-800',
        };
        return colors[categoryName] || 'from-gray-500 to-gray-700';
    };

    const featuredBlogs = blogData?.featured || [];
    const latestBlogs = blogData?.latest || [];

    return (
        <div className={`min-h-screen ${isDarkMode ? 'bg-gray-900' : 'bg-white'}`}>
            {/* Hero Section */}
            <section className={`relative min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 ${
                isDarkMode 
                    ? 'bg-gradient-to-br from-gray-900 via-indigo-900 to-purple-900' 
                    : 'bg-gradient-to-br from-indigo-50 via-white to-purple-50'
            }`}>
                {/* Subtle Background Pattern */}
                <div className="absolute inset-0 opacity-10">
                    <div className="absolute top-20 left-10 w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></div>
                    <div className="absolute top-40 right-20 w-1 h-1 bg-purple-500 rounded-full animate-ping"></div>
                    <div className="absolute bottom-20 left-1/4 w-1.5 h-1.5 bg-indigo-400 rounded-full animate-pulse"></div>
                    <div className="absolute top-1/2 right-1/3 w-1 h-1 bg-purple-400 rounded-full animate-bounce"></div>
                </div>

                <div className="relative max-w-4xl mx-auto text-center">
                    <div className="animate-fade-in">
                        <div className="text-2xl mb-6">
                             Hi, I'm Muhammad Nawaz
                        </div>
                        <h1 className={`text-5xl md:text-6xl lg:text-7xl font-bold leading-tight mb-8 ${
                            isDarkMode ? 'text-white' : 'text-gray-900'
                        }`}>
                            Full-Stack Software Engineer
                            <span className={`block ${isDarkMode ? 'text-indigo-400' : 'text-indigo-600'}`}>
                                & Technical Writer
                            </span>
                        </h1>
                        <p className={`text-xl md:text-2xl leading-relaxed mb-12 max-w-3xl mx-auto ${
                            isDarkMode ? 'text-gray-300' : 'text-gray-600'
                        }`}>
                            I build intelligent, scalable, and performance-driven web applications.<br />
                            From backend architecture to cloud deployment — I handle it all.
                        </p>
                        <div className="flex flex-col sm:flex-row gap-6 justify-center">
                            <a
                                href="/blog"
                                className={`px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:scale-105 ${
                                    isDarkMode 
                                        ? 'bg-indigo-600 hover:bg-indigo-700 text-white' 
                                        : 'bg-indigo-600 hover:bg-indigo-700 text-white'
                                }`}
                            >
                                Read Blog
                            </a>
                            <a
                                href="#contact"
                                className={`px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:scale-105 border-2 ${
                                    isDarkMode 
                                        ? 'border-indigo-400 text-indigo-400 hover:bg-indigo-400 hover:text-white' 
                                        : 'border-indigo-600 text-indigo-600 hover:bg-indigo-600 hover:text-white'
                                }`}
                            >
                                Contact Me
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            {/* About Section */}
            <section id="about" className={`py-24 px-4 sm:px-6 lg:px-8 ${
                isDarkMode ? 'bg-gray-800' : 'bg-gray-50'
            }`}>
                <div className="max-w-7xl mx-auto">
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                        {/* Left Side - Text */}
                        <div className={`${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                            <h2 className="text-4xl md:text-5xl font-bold mb-8">
                                About Me
                            </h2>
                            <div className="space-y-6 text-lg leading-relaxed">
                                <p className={`${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                                    With a strong background in full-stack development, I specialize in crafting modern, 
                                    scalable web applications using technologies like <span className={`${isDarkMode ? 'text-indigo-400' : 'text-indigo-600'} font-semibold`}>Laravel</span>, 
                                    <span className={`${isDarkMode ? 'text-indigo-400' : 'text-indigo-600'} font-semibold`}> Next.js</span>, 
                                    <span className={`${isDarkMode ? 'text-indigo-400' : 'text-indigo-600'} font-semibold`}> Node.js</span>, 
                                    <span className={`${isDarkMode ? 'text-indigo-400' : 'text-indigo-600'} font-semibold`}> Tailwind</span>, and 
                                    <span className={`${isDarkMode ? 'text-indigo-400' : 'text-indigo-600'} font-semibold`}> MySQL</span>.
                                </p>
                                <p className={`${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                                    My mission is to build digital products that combine technical excellence with user-centric design.
                                </p>
                            </div>
                        </div>

                        {/* Right Side - Profile Picture */}
                        <div className="relative">
                            <div className="relative">
                                {/* Profile Image */}
                                <div className="relative w-80 h-80 mx-auto">
                                    <img 
                                        src="/assets/profile/Muhammad Nawaz(Software Enginer).png" 
                                        alt="Muhammad Nawaz - Full-Stack Software Engineer" 
                                        className="w-full h-full object-cover rounded-2xl shadow-2xl border-4 border-white/20"
                                    />
                                    {/* Subtle overlay for professional look */}
                                    <div className="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-purple-600/10 rounded-2xl"></div>
                                </div>

                                {/* Floating elements for visual interest */}
                                <div className="absolute -top-4 -right-4 w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center animate-pulse">
                                 </div>
                                <div className="absolute -bottom-4 -left-4 w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center animate-bounce">
                                     
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Featured Blog Posts Slider */}
            {featuredBlogs.length > 0 && (
                <section className={`py-24 px-4 sm:px-6 lg:px-8 ${
                    isDarkMode ? 'bg-gray-800' : 'bg-gray-50'
                }`}>
                    <div className="max-w-7xl mx-auto">
                        <div className="text-center mb-16">
                            <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${
                                isDarkMode ? 'text-white' : 'text-gray-900'
                            }`}>
                                Featured Articles
                            </h2>
                            <p className={`text-xl ${
                                isDarkMode ? 'text-gray-300' : 'text-gray-600'
                            }`}>
                                Handpicked articles showcasing my best work
                            </p>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                            {featuredBlogs.map((blog, index) => (
                                <article
                                    key={blog.id}
                                    className={`${isDarkMode ? 'bg-gray-900' : 'bg-white'} rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border ${
                                        isDarkMode ? 'border-gray-700' : 'border-gray-200'
                                    } overflow-hidden group`}
                                    style={{
                                        animationDelay: `${index * 150}ms`,
                                        animation: 'fadeInUp 0.6s ease-out forwards'
                                    }}
                                >
                                    <div className={`h-48 bg-gradient-to-br ${getCategoryColor(blog.category)} relative overflow-hidden`}>
                                        {blog.featured_image && (
                                            <img 
                                                src={blog.featured_image} 
                                                alt={blog.featured_image_alt || blog.title}
                                                className="w-full h-full object-cover"
                                            />
                                        )}
                                        <div className="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-all duration-500"></div>
                                        <div className="absolute top-4 left-4">
                                            <span className={`px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm ${isDarkMode ? 'bg-gray-800/80 text-white' : 'bg-white/90 text-gray-900'}`}>
                                                {blog.category}
                                            </span>
                                        </div>
                                        <div className="absolute bottom-4 right-4 flex items-center space-x-2">
                                            <div className={`flex items-center space-x-1 px-2 py-1 rounded-full backdrop-blur-sm ${isDarkMode ? 'bg-gray-800/80 text-white' : 'bg-white/90 text-gray-900'}`}>
                                                <i className="fas fa-heart text-xs"></i>
                                                <span className="text-xs">{blog.likes_count}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="p-6">
                                        <div className={`flex items-center text-sm mb-4 ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
                                            <span>{blog.publish_date}</span>
                                            <span className="mx-2">•</span>
                                            <span>{blog.reading_time}</span>
                                        </div>
                                        <h3 className={`text-lg font-semibold mb-3 group-hover:text-indigo-500 transition-colors duration-300 ${
                                            isDarkMode ? 'text-white' : 'text-gray-900'
                                        }`}>
                                            {blog.title}
                                        </h3>
                                        <p className={`text-sm mb-4 leading-relaxed ${
                                            isDarkMode ? 'text-gray-300' : 'text-gray-600'
                                        }`}>
                                            {blog.excerpt}
                                        </p>
                                        <div className="flex items-center justify-between">
                                            <div className={`text-xs ${
                                                isDarkMode ? 'text-gray-400' : 'text-gray-500'
                                            }`}>
                                                {blog.author}
                                            </div>
                                            <a
                                                href={`/blog/${blog.slug}`}
                                                className={`text-sm font-medium flex items-center group transition-all duration-300 ${
                                                    isDarkMode ? 'text-indigo-400 hover:text-indigo-300' : 'text-indigo-600 hover:text-indigo-700'
                                                }`}
                                            >
                                                Read More
                                                <i className="fas fa-chevron-right ml-1 group-hover:translate-x-1 transition-transform duration-300 text-xs"></i>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            ))}
                        </div>
                    </div>
                </section>
            )}

            {/* Latest Blog Posts */}
            {latestBlogs.length > 0 && (
                <section id="blog" className={`py-24 px-4 sm:px-6 lg:px-8 ${
                    isDarkMode ? 'bg-gray-900' : 'bg-white'
                }`}>
                    <div className="max-w-7xl mx-auto">
                        <div className="text-center mb-16">
                            <h2 className={`text-4xl md:text-5xl font-bold mb-6 ${
                                isDarkMode ? 'text-white' : 'text-gray-900'
                            }`}>
                                Latest Blog Posts
                            </h2>
                            <p className={`text-xl ${
                                isDarkMode ? 'text-gray-300' : 'text-gray-600'
                            }`}>
                                Fresh insights and tutorials from my development journey
                            </p>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {latestBlogs.map((blog, index) => (
                                <article
                                    key={blog.id}
                                    className={`${isDarkMode ? 'bg-gray-800' : 'bg-white'} rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border ${
                                        isDarkMode ? 'border-gray-700' : 'border-gray-200'
                                    }`}
                                >
                                    <div className={`text-sm mb-3 ${
                                        isDarkMode ? 'text-indigo-400' : 'text-indigo-600'
                                    }`}>
                                        {blog.category}
                                    </div>
                                    <h3 className={`text-lg font-semibold mb-3 ${
                                        isDarkMode ? 'text-white' : 'text-gray-900'
                                    }`}>
                                        {blog.title}
                                    </h3>
                                    <p className={`text-sm mb-4 ${
                                        isDarkMode ? 'text-gray-300' : 'text-gray-600'
                                    }`}>
                                        {blog.excerpt}
                                    </p>
                                    <div className="flex items-center justify-between">
                                        <div className={`text-xs ${
                                            isDarkMode ? 'text-gray-400' : 'text-gray-500'
                                        }`}>
                                            {blog.publish_date} • {blog.reading_time}
                                        </div>
                                        <a
                                            href={`/blog/${blog.slug}`}
                                            className={`text-sm font-medium ${
                                                isDarkMode ? 'text-indigo-400 hover:text-indigo-300' : 'text-indigo-600 hover:text-indigo-700'
                                            }`}
                                        >
                                            Read More →
                                        </a>
                                    </div>
                                </article>
                            ))}
                        </div>

                        {/* View All Blogs Button */}
                        <div className="text-center mt-12">
                            <a
                                href="/blog"
                                className={`inline-flex items-center px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:scale-105 ${
                                    isDarkMode 
                                        ? 'bg-indigo-600 hover:bg-indigo-700 text-white' 
                                        : 'bg-indigo-600 hover:bg-indigo-700 text-white'
                                }`}
                            >
                                View All Articles
                                <i className="fas fa-chevron-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </section>
            )}
  {/* Enhanced Testimonial Section - Moved to before footer */}
  <section className={`py-24 px-6 transition-colors duration-500 overflow-hidden ${
                isDarkMode 
                    ? 'bg-gradient-to-br from-gray-900 via-gray-950 to-black' 
                    : 'bg-gradient-to-br from-blue-50 via-white to-purple-50'
            }`}>
                {/* Background Elements */}
                <div className="absolute inset-0 overflow-hidden">
                    <div className={`absolute -top-40 -right-40 w-80 h-80 rounded-full blur-3xl opacity-20 ${
                        isDarkMode ? 'bg-purple-600' : 'bg-purple-300'
                    }`}></div>
                    <div className={`absolute -bottom-40 -left-40 w-80 h-80 rounded-full blur-3xl opacity-20 ${
                        isDarkMode ? 'bg-blue-600' : 'bg-blue-300'
                    }`}></div>
                </div>

                <div className="max-w-7xl mx-auto relative z-10">
                    {/* Header */}
                    <div className="text-center mb-20 animate-fade-in">
                        <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full border mb-6">
                            <div className="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></div>
                            <span className={`text-sm font-medium ${
                                isDarkMode ? 'text-gray-300' : 'text-gray-600'
                            }`}>
                                Client Testimonials
                            </span>
                        </div>
                        
                        <h2 className={`text-5xl md:text-6xl font-bold mb-6 bg-gradient-to-r ${
                            isDarkMode 
                                ? 'from-white to-gray-400' 
                                : 'from-gray-900 to-gray-600'
                        } bg-clip-text text-transparent`}>
                            Trusted by Amazing
                            <span className="block text-indigo-400">Clients</span>
                        </h2>
                        
                        <p className={`text-xl max-w-2xl mx-auto leading-relaxed ${
                            isDarkMode ? 'text-gray-400' : 'text-gray-600'
                        }`}>
                            Don't just take our word for it. Here's what our clients have to say about their experience.
                        </p>
                    </div>

                    {/* Testimonial Cards */}
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                        {testimonials.map((testimonial, index) => (
                            <div
                                key={testimonial.id}
                                className={`relative group cursor-pointer testimonial-card ${
                                    index === 1 ? 'lg:mt-8' : ''
                                }`}
                                style={{ animationDelay: `${index * 0.2}s` }}
                            >
                                {/* Card */}
                                <div className={`relative rounded-3xl p-8 border-2 backdrop-blur-xl transition-all duration-500 ${
                                    isDarkMode
                                        ? 'bg-gray-800/40 border-gray-700/50 hover:border-indigo-400/30'
                                        : 'bg-white/70 border-gray-200/50 hover:border-indigo-400/50'
                                } group-hover:shadow-2xl group-hover:scale-105 group-hover:-translate-y-2`}>
                                    
                                    {/* Quote Icon */}
                                    <div className={`absolute -top-4 -left-4 w-12 h-12 rounded-2xl flex items-center justify-center bg-indigo-500`}>
                                    <i className="fas fa-quote-left text-white text-lg"></i>

                                    </div>

                                    {/* Stars */}
                                    <div className="flex justify-center mb-6">
                                        {Array.from({ length: 5 }).map((_, i) => (
                                            <i key={i} className="fas fa-star text-indigo-400 text-lg"></i>
                                        ))}
                                    </div>

                                    {/* Content */}
                                    <p className={`text-lg leading-relaxed mb-8 text-center italic ${
                                        isDarkMode ? 'text-gray-300' : 'text-gray-700'
                                    }`}>
                                        "{testimonial.content}"
                                    </p>

                                    {/* Client Info */}
                                    <div className="flex items-center justify-center gap-4">
                                        <div className="relative">
                                            <img
                                                src={testimonial.image}
                                                alt={testimonial.name}
                                                className="w-14 h-14 rounded-full object-cover border-2 border-indigo-400"
                                            />
                                            <div className="absolute -bottom-1 -right-1 w-5 h-5 bg-green-400 rounded-full border-2 border-white">
                                                <i className="fas fa-circle text-xs text-white"></i>
                                            </div>
                                        </div>
                                        <div className="text-left">
                                            <h3 className={`font-bold text-lg ${
                                                isDarkMode ? 'text-white' : 'text-gray-900'
                                            }`}>
                                                {testimonial.name}
                                            </h3>
                                            <p className="text-indigo-400 text-sm font-medium">
                                                {testimonial.role}
                                            </p>
                                        </div>
                                    </div>

                                    {/* Hover Effect */}
                                    <div className={`absolute inset-0 rounded-3xl bg-gradient-to-br opacity-0 group-hover:opacity-5 transition-opacity duration-500 ${
                                        isDarkMode 
                                            ? 'from-indigo-400 to-purple-400' 
                                            : 'from-indigo-300 to-purple-300'
                                    }`}></div>
                                </div>

                                {/* Background Glow */}
                                <div className={`absolute inset-0 rounded-3xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity duration-500 ${
                                    isDarkMode ? 'bg-indigo-400/20' : 'bg-indigo-400/10'
                                } -z-10`}></div>
                            </div>
                        ))}
                    </div>

                    {/* Bottom CTA */}
                    <div className="text-center mt-16 animate-fade-in-delayed">
                        <div className={`inline-flex items-center gap-3 px-6 py-4 rounded-2xl border ${
                            isDarkMode 
                                ? 'bg-gray-800/50 border-gray-700' 
                                : 'bg-white/50 border-gray-200'
                        } backdrop-blur-lg`}>
                            <div className="flex -space-x-3">
                                {testimonials.map(testimonial => (
                                    <img
                                        key={testimonial.id}
                                        src={testimonial.image}
                                        alt={testimonial.name}
                                        className="w-10 h-10 rounded-full border-2 border-white object-cover"
                                    />
                                ))}
                            </div>
                            <div className="text-left">
                                <p className={`font-semibold ${
                                    isDarkMode ? 'text-white' : 'text-gray-900'
                                }`}>
                                    Join 50+ satisfied clients
                                </p>
                                <p className={`text-sm ${
                                    isDarkMode ? 'text-gray-400' : 'text-gray-600'
                                }`}>
                                    Ready to start your project?
                                </p>
                            </div>
                            <button className={`ml-4 px-6 py-2 rounded-xl font-semibold transition-all duration-300 ${
                                isDarkMode
                                    ? 'bg-indigo-500 text-white hover:bg-indigo-400'
                                    : 'bg-indigo-500 text-white hover:bg-indigo-400'
                            }`}>
                                Get Started
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            {/* Contact Section */}
            <section id="contact" className={`py-24 px-4 sm:px-6 lg:px-8 ${
                isDarkMode ? 'bg-gray-800' : 'bg-gray-50'
            }`}>
                <div className="max-w-4xl mx-auto text-center">
                    <h2 className={`text-4xl md:text-5xl font-bold mb-8 ${
                        isDarkMode ? 'text-white' : 'text-gray-900'
                    }`}>
                        Let's build something great together.
                    </h2>
                    <div className="flex flex-col sm:flex-row gap-6 justify-center mb-12">
                        <a
                            href="mailto:sardarnawaz122@gmail.com"
                            className={`px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:scale-105 ${
                                isDarkMode 
                                    ? 'bg-indigo-600 hover:bg-indigo-700 text-white' 
                                    : 'bg-indigo-600 hover:bg-indigo-700 text-white'
                            }`}
                        >
                            <i className="fas fa-envelope mr-2"></i>
                            Email Me
                        </a>
                        <a
                            href="https://www.linkedin.com/in/muhammad-nawaz-43a354201/"
                            className={`px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:scale-105 border-2 ${
                                isDarkMode 
                                    ? 'border-indigo-400 text-indigo-400 hover:bg-indigo-400 hover:text-white' 
                                    : 'border-indigo-600 text-indigo-600 hover:bg-indigo-600 hover:text-white'
                            }`}
                        >
                            <i className="fab fa-linkedin mr-2"></i>
                            LinkedIn
                        </a>
                        <a
                            href="https://github.com/nawazfdev"
                            className={`px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:scale-105 border-2 ${
                                isDarkMode 
                                    ? 'border-gray-400 text-gray-400 hover:bg-gray-400 hover:text-white' 
                                    : 'border-gray-600 text-gray-600 hover:bg-gray-600 hover:text-white'
                            }`}
                        >
                            <i className="fab fa-github mr-2"></i>
                            GitHub
                        </a>
                    </div>
                </div>
            </section>

          
            {/* Footer */}
            <footer className={`py-8 ${isDarkMode ? 'bg-gray-900 border-t border-gray-700' : 'bg-white border-t border-gray-200'}`}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <p className={`${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                        © 2025 Muhammad Nawaz — Built with <i className="fas fa-heart text-red-500 mx-1"></i> using modern full-stack technologies.
                    </p>
                </div>
            </footer>
        </div>
    );
};

export default Home;