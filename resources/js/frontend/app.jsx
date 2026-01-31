import React, { useState, useEffect } from 'react';
import { createRoot } from 'react-dom/client';
import '../../css/app.css';
import Layout from './layouts/Layout';
import Home from './pages/Home';
import Blog from './pages/Blog';
import BlogDetail from './pages/BlogDetail';
import About from './pages/About';
import Contact from './pages/Contact';
import Services from './pages/Services';
import Articles from './pages/Articles';
import Tutorials from './pages/Tutorials';
import ArticleDetail from './pages/ArticleDetail';
import HireUs from './pages/HireUs';
import SoftwareEngineer from './pages/SoftwareEngineer';
import CaseStudies from './pages/CaseStudies';
import Projects from './pages/Projects';
import Resume from './pages/Resume';
import Faq from './pages/Faq';
import ServicesLaravel from './pages/ServicesLaravel';
import ServicesApi from './pages/ServicesApi';
import ServicesPerformance from './pages/ServicesPerformance';
import JsonFormatter from './pages/JsonFormatter';
import Base64Tool from './pages/Base64Tool';
import HashGenerator from './pages/HashGenerator';
import UrlEncoderDecoder from './pages/UrlEncoderDecoder';
import TimestampConverter from './pages/TimestampConverter';
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
    
    // Check if it's a blog detail page (e.g., /blog/slug)
    if (currentPath.startsWith('/blog/')) {
        PageComponent = BlogDetail;
    } else if (currentPath.startsWith('/article/')) {
        PageComponent = ArticleDetail;
    } else {
    switch (currentPath) {
        case '/blog':
            PageComponent = Blog;
            break;
        case '/services':
            PageComponent = Services;
            break;
        case '/articles':
            PageComponent = Articles;
            break;
        case '/tutorials':
            PageComponent = Tutorials;
            break;
        case '/contact':
            PageComponent = Contact;
            break;
        case '/hire-us':
            PageComponent = HireUs;
            break;
        case '/software-engineer':
            PageComponent = SoftwareEngineer;
            break;
        case '/case-studies':
            PageComponent = CaseStudies;
            break;
        case '/projects':
            PageComponent = Projects;
            break;
        case '/resume':
            PageComponent = Resume;
            break;
        case '/faq':
            PageComponent = Faq;
            break;
        case '/services/laravel-development':
            PageComponent = ServicesLaravel;
            break;
        case '/services/api-development':
            PageComponent = ServicesApi;
            break;
        case '/services/performance-optimization':
            PageComponent = ServicesPerformance;
            break;
        case '/tools/json-formatter':
            PageComponent = JsonFormatter;
            break;
        case '/tools/base64-encoder-decoder':
            PageComponent = Base64Tool;
            break;
        case '/tools/hash-generator':
            PageComponent = HashGenerator;
            break;
        case '/tools/url-encoder-decoder':
            PageComponent = UrlEncoderDecoder;
            break;
        case '/tools/timestamp-converter':
            PageComponent = TimestampConverter;
            break;
        case '/about':
            PageComponent = About;
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