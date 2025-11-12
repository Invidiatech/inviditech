import React, { useState, useEffect } from 'react';
import { createRoot } from 'react-dom/client';
import '../../css/app.css';
import Layout from './layouts/Layout';
import Home from './pages/Home';
import Blog from './pages/Blog';
import BlogDetail from './pages/BlogDetail';
import About from './pages/About';
import Contact from './pages/Contact';
import "@fortawesome/fontawesome-free/css/all.min.css";

// Main App Component
const App = () => {
    const [currentPath, setCurrentPath] = useState(window.location.pathname);
    const [blogData, setBlogData] = useState(null);
    const [currentBlog, setCurrentBlog] = useState(null);
    
    // Get blog data from Laravel
    useEffect(() => {
        const container = document.getElementById('react-app');
        if (container) {
            const blogDataAttribute = container.getAttribute('data-blog-data');
            const currentBlogAttribute = container.getAttribute('data-current-blog');
            
            if (blogDataAttribute) {
                try {
                    const parsedData = JSON.parse(blogDataAttribute);
                    setBlogData(parsedData);
                } catch (error) {
                    console.error('Error parsing blog data:', error);
                }
            }
            
            if (currentBlogAttribute) {
                try {
                    const parsedBlog = JSON.parse(currentBlogAttribute);
                    setCurrentBlog(parsedBlog);
                } catch (error) {
                    console.error('Error parsing current blog data:', error);
                }
            }
        }
    }, []);

    // Handle navigation
    useEffect(() => {
        const handlePopState = () => {
            setCurrentPath(window.location.pathname);
        };
        
        window.addEventListener('popstate', handlePopState);
        return () => window.removeEventListener('popstate', handlePopState);
    }, []);
    
    let PageComponent;
    
    // Check if it's a blog detail page (e.g., /blog/1, /blog/2, etc.)
    if (currentPath.startsWith('/blog/')) {
        PageComponent = BlogDetail;
        } else {
    switch (currentPath) {
        case '/blog':
            PageComponent = Blog;
            break;
        case '/about':
            PageComponent = About;
            break;
                case '/contact':
                    PageComponent = Contact;
                    break;
        default:
            PageComponent = Home;
            }
    }
    
    return (
        <Layout>
            <PageComponent blogData={blogData} currentBlog={currentBlog} />
        </Layout>
    );
};

// Initialize React app immediately
    const container = document.getElementById('react-app');
    if (container) {
        const root = createRoot(container);
        root.render(<App />);
    } else {
        console.error('React container not found!');
    }