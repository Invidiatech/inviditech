@extends('website.layouts.app')
@section('title', 'FAQ - InvidiaTech')
@section('meta_title', 'FAQ - InvidiaTech')
@section('meta_description', 'Answers to common questions about hiring InvidiaTech for Laravel and web development projects.')
@section('meta_keywords', 'FAQ, Laravel Developer, Hire Software Engineer, InvidiaTech')

@section('schema_markup')
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What services do you offer?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "We offer Laravel development, API engineering, performance optimization, and custom web applications."
      }
    },
    {
      "@type": "Question",
      "name": "How do I start a project?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Use the contact form to share project goals, timeline, and budget. We will follow up with a plan."
      }
    },
    {
      "@type": "Question",
      "name": "Do you provide ongoing support?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. Maintenance, monitoring, and feature iteration are available after launch."
      }
    }
  ]
}
@endsection

@section('content')
<section class="page-header">
    <div class="page-header-pattern"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center animate">
                <h1 class="fw-bold mb-3">Frequently Asked Questions</h1>
                <p class="lead">Quick answers to common questions about working together.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeadingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne" aria-expanded="true" aria-controls="faqOne">
                        What services do you offer?
                    </button>
                </h2>
                <div id="faqOne" class="accordion-collapse collapse show" aria-labelledby="faqHeadingOne" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Laravel development, API engineering, performance optimization, and custom web applications.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeadingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo" aria-expanded="false" aria-controls="faqTwo">
                        How do I start a project?
                    </button>
                </h2>
                <div id="faqTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Share project goals, timelines, and requirements via the contact form. We will respond with a plan.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeadingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqThree" aria-expanded="false" aria-controls="faqThree">
                        Do you provide ongoing support?
                    </button>
                </h2>
                <div id="faqThree" class="accordion-collapse collapse" aria-labelledby="faqHeadingThree" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes, ongoing maintenance, monitoring, and feature iteration are available after launch.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
