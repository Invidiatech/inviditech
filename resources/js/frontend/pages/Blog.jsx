import React, { useState, useEffect } from 'react';

const Blog = ({ isDarkMode, blogData }) => {
    const [selectedCategory, setSelectedCategory] = useState('All');
    const [searchTerm, setSearchTerm] = useState('');
    const [blogs, setBlogs] = useState([]);
    const [categories, setCategories] = useState([]);
    const [loading, setLoading] = useState(false);

    // Initialize data from props
    useEffect(() => {
        if (blogData) {
            setBlogs(blogData.all || []);
            // Add 'All' option to categories
            const allCategories = [{ id: 'all', name: 'All', slug: 'all' }, ...(blogData.categories || [])];
            setCategories(allCategories);
        }
    }, [blogData]);

    // Filter blogs based on search and category
    useEffect(() => {
        if (!blogData) return;

        let filteredBlogs = blogData.all || [];

        // Apply category filter
        if (selectedCategory !== 'All') {
            filteredBlogs = filteredBlogs.filter(blog => blog.category === selectedCategory);
        }

        // Apply search filter
        if (searchTerm) {
            filteredBlogs = filteredBlogs.filter(blog => 
                blog.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
                blog.excerpt.toLowerCase().includes(searchTerm.toLowerCase()) ||
                blog.tags.some(tag => tag.name.toLowerCase().includes(searchTerm.toLowerCase()))
            );
        }

        setBlogs(filteredBlogs);
    }, [selectedCategory, searchTerm, blogData]);

    const handleSearchChange = (e) => {
        setSearchTerm(e.target.value);
    };

    const handleCategoryChange = (category) => {
        setSelectedCategory(category);
    };

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

    // Show loading state only if blogData is null/undefined
    if (blogData === null || blogData === undefined) {
        return (
            <div className={`min-h-screen flex items-center justify-center ${isDarkMode ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <div className="text-center">
                    <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mx-auto mb-4"></div>
                    <p className={`${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>Loading blogs...</p>
                </div>
            </div>
        );
    }


    return (
        <div className={`min-h-screen ${isDarkMode ? 'bg-gray-900' : 'bg-gray-50'}`}>
            {/* Hero Section */}
            <section className={`py-20 px-4 sm:px-6 lg:px-8 ${isDarkMode ? 'bg-gray-800' : 'bg-white'}`}>
                <div className="max-w-6xl mx-auto text-center">
                    <h1 className={`text-5xl md:text-6xl font-bold mb-6 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                        Latest Blog Posts
                    </h1>
                    <p className={`text-xl mb-8 max-w-3xl mx-auto ${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                        Sharing knowledge and insights from my development journey. Explore articles on modern web development, architecture, and best practices.
                    </p>
                </div>
            </section>

            {/* Search and Filter Section */}
            <section className={`py-8 px-4 sm:px-6 lg:px-8 ${isDarkMode ? 'bg-gray-800' : 'bg-white'} border-b ${isDarkMode ? 'border-gray-700' : 'border-gray-200'}`}>
                <div className="max-w-7xl mx-auto">
                    <div className="flex flex-col md:flex-row gap-6 items-center justify-between">
                        {/* Search Bar */}
                        <div className="relative flex-1 max-w-md">
                            <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg className="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input
                                type="text"
                                placeholder="Search articles..."
                                value={searchTerm}
                                onChange={handleSearchChange}
                                className={`block w-full pl-10 pr-3 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-200 ${
                                    isDarkMode 
                                        ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' 
                                        : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500'
                                }`}
                            />
                        </div>

                        {/* Category Filter */}
                        <div className="flex flex-wrap gap-2">
                            {categories.map((category) => (
                                <button
                                    key={category.id}
                                    onClick={() => handleCategoryChange(category.name)}
                                    className={`px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 ${
                                        selectedCategory === category.name
                                            ? isDarkMode
                                                ? 'bg-indigo-600 text-white'
                                                : 'bg-indigo-600 text-white'
                                            : isDarkMode
                                                ? 'bg-gray-700 text-gray-300 hover:bg-gray-600'
                                                : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
                                    }`}
                                >
                                    {category.name}
                                    {category.blogs_count && (
                                        <span className="ml-1 text-xs opacity-75">
                                            ({category.blogs_count})
                                        </span>
                                    )}
                                </button>
                            ))}
                        </div>
                    </div>
                </div>
            </section>

            {/* Blog Posts */}
            <section className={`py-16 px-4 sm:px-6 lg:px-8 ${isDarkMode ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <div className="max-w-7xl mx-auto">
                    {blogs.length === 0 ? (
                        <div className="text-center py-12">
                            <div className="text-6xl mb-4">🔍</div>
                            <h3 className={`text-2xl font-bold mb-4 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                No articles found
                            </h3>
                            <p className={`${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                                Try adjusting your search terms or category filter.
                            </p>
                        </div>
                    ) : (
                        <div className="grid md:grid-cols-2 xl:grid-cols-3 gap-8">
                            {blogs.map((blog, index) => (
                                <article 
                                    key={blog.id} 
                                    className={`${isDarkMode ? 'bg-gray-800' : 'bg-white'} rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden group cursor-pointer border ${isDarkMode ? 'border-gray-700' : 'border-gray-200'} hover:scale-105`}
                                    style={{
                                        animationDelay: `${index * 100}ms`,
                                        animation: 'fadeInUp 0.6s ease-out forwards'
                                    }}
                                >
                                    <div className={`h-64 bg-gradient-to-br ${getCategoryColor(blog.category)} relative overflow-hidden`}>
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
                                                <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.834a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                </svg>
                                                <span className="text-xs">{blog.likes_count}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="p-6">
                                        <div className={`flex items-center text-sm mb-4 ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
                                            <span>{blog.publish_date}</span>
                                            <span className="mx-2">•</span>
                                            <span>{blog.reading_time}</span>
                                            <span className="mx-2">•</span>
                                            <span>{blog.author}</span>
                                        </div>
                                        <h3 className={`text-xl font-bold transition-all duration-300 mb-4 group-hover:text-indigo-500 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                            {blog.title}
                                        </h3>
                                        <p className={`mb-6 leading-relaxed text-sm ${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                                            {blog.excerpt}
                                        </p>
                                        
                                        {/* Tags */}
                                        <div className="flex flex-wrap gap-2 mb-6">
                                            {blog.tags.slice(0, 3).map((tag, tagIndex) => (
                                                <span 
                                                    key={tagIndex}
                                                    className={`px-2 py-1 rounded-full text-xs font-medium ${
                                                        isDarkMode 
                                                            ? 'bg-gray-700 text-gray-300' 
                                                            : 'bg-gray-100 text-gray-600'
                                                    }`}
                                                >
                                                    {tag.name}
                                                </span>
                                            ))}
                                        </div>

                                        {/* Actions */}
                                        <div className="flex items-center justify-between">
                                            <div className="flex items-center space-x-4">
                                                <div className={`flex items-center space-x-1 ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
                                                    <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.834a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                    </svg>
                                                    <span className="text-sm">{blog.likes_count}</span>
                                                </div>
                                                <div className={`flex items-center space-x-1 ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
                                                    <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                    </svg>
                                                    <span className="text-sm">{blog.comments_count}</span>
                                                </div>
                                            </div>
                                            <a 
                                                href={`/blog/${blog.slug}`}
                                                className={`font-semibold flex items-center group transition-all duration-300 ${isDarkMode ? 'text-indigo-400 hover:text-indigo-300' : 'text-indigo-600 hover:text-indigo-700'}`}
                                            >
                                                Read More
                                                <svg className="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            ))}
                        </div>
                    )}
                    
                </div>
            </section>
        </div>
    );
};

export default Blog;