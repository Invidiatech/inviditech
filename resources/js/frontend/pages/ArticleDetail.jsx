import React from 'react';
import { useParams } from 'react-router-dom';

const ArticleDetail = () => {
    const { slug } = useParams();

    return (
        <div className="bg-white">
            <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div className="text-center mb-12">
                    <h1 className="text-4xl font-bold text-gray-900 mb-4">Article: {slug}</h1>
                    <p className="text-xl text-gray-600">
                        This article page will display the full content of the selected article.
                    </p>
                </div>
                
                <div className="text-center py-20">
                    <div className="text-6xl mb-4">📄</div>
                    <h2 className="text-2xl font-bold text-gray-900 mb-4">Article Content</h2>
                    <p className="text-gray-600">
                        The full article content will be loaded here from the backend API.
                    </p>
                </div>
            </div>
        </div>
    );
};

export default ArticleDetail;
