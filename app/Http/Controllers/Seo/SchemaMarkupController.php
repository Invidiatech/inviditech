<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use App\Models\Seo\SchemaMarkup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SchemaMarkupController extends Controller
{
    /**
     * Display a listing of the schema markups
     */
    public function index(Request $request)
    {
        $query = SchemaMarkup::with('creator');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
            });
        }

        // Type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Validation status filter
        if ($request->filled('validation_status')) {
            $query->where('validation_status', $request->validation_status);
        }

        $schemas = $query->latest()->paginate(15);

        // Statistics
        $stats = [
            'total' => SchemaMarkup::count(),
            'active' => SchemaMarkup::where('status', 'active')->count(),
            'valid' => SchemaMarkup::where('validation_status', 'valid')->count(),
            'invalid' => SchemaMarkup::where('validation_status', 'invalid')->count(),
        ];

        return view('seo.schema.index', compact('schemas', 'stats'));
    }

    /**
     * Show the form for creating a new schema markup
     */
    public function create()
    {
        $schemaTypes = SchemaMarkup::SCHEMA_TYPES;
        return view('seo.schema.create', compact('schemaTypes'));
    }

    /**
     * Store a newly created schema markup
     */
    public function store(Request $request)
    {
        // Add debugging
        \Log::info('Schema Store Request Data:', $request->all());

        // First validate the basic fields
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:' . implode(',', array_keys(SchemaMarkup::SCHEMA_TYPES)),
            'schema_data' => 'required|string', // Validate as string first
            'pages' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        \Log::info('Validation passed');

        try {
            // Convert JSON string to array
            $schemaData = json_decode($request->schema_data, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                \Log::error('JSON Decode Error: ' . json_last_error_msg());
                return redirect()->back()
                    ->with('error', 'Invalid JSON format: ' . json_last_error_msg())
                    ->withInput();
            }

            \Log::info('JSON decoded successfully');

            // Convert pages string to array
            $pages = null;
            if ($request->filled('pages')) {
                $pages = array_filter(
                    array_map('trim', explode("\n", $request->pages)),
                    function($page) { return !empty($page); }
                );
            }

            $validated = [
                'name' => $request->name,
                'type' => $request->type,
                'schema_data' => $schemaData, // Store as array
                'pages' => $pages,
                'status' => $request->status,
                'created_by' => Auth::guard('seo')->id(),
                'validation_status' => 'pending'
            ];

            \Log::info('Creating schema with data:', $validated);

            $schema = SchemaMarkup::create($validated);

            \Log::info('Schema created with ID: ' . $schema->id);

            // Validate the schema
            $validationResult = $this->validateSchema($schema);
            \Log::info('Schema validation result:', $validationResult);

            return redirect()->route('seo.schema.index')
                ->with('success', 'Schema markup created successfully with ID: ' . $schema->id);

        } catch (\Exception $e) {
            \Log::error('Error creating schema markup: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Error creating schema markup: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified schema markup
     */
    public function show(SchemaMarkup $schema)
    {
        $schema->load('creator');
        return view('seo.schema.show', compact('schema'));
    }

    /**
     * Show the form for editing the specified schema markup
     */
    public function edit(SchemaMarkup $schema)
    {
        $schemaTypes = SchemaMarkup::SCHEMA_TYPES;
        return view('seo.schema.edit', compact('schema', 'schemaTypes'));
    }

    /**
     * Update the specified schema markup
     */
    public function update(Request $request, SchemaMarkup $schema)
    {
        // First validate the basic fields
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:' . implode(',', array_keys(SchemaMarkup::SCHEMA_TYPES)),
            'schema_data' => 'required|string', // Validate as string first
            'pages' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        try {
            // Convert JSON string to array
            $schemaData = json_decode($request->schema_data, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return redirect()->back()
                    ->with('error', 'Invalid JSON format: ' . json_last_error_msg())
                    ->withInput();
            }

            // Convert pages string to array
            $pages = null;
            if ($request->filled('pages')) {
                $pages = array_filter(
                    array_map('trim', explode("\n", $request->pages)),
                    function($page) { return !empty($page); }
                );
            }

            $validated = [
                'name' => $request->name,
                'type' => $request->type,
                'schema_data' => $schemaData, // Store as array
                'pages' => $pages,
                'status' => $request->status
            ];

            $schema->update($validated);

            // Re-validate the schema
            $this->validateSchema($schema);

            return redirect()->route('seo.schema.index')
                ->with('success', 'Schema markup updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating schema markup: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error updating schema markup: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified schema markup
     */
    public function destroy(SchemaMarkup $schema)
    {
        try {
            $schema->delete();
            return redirect()->route('seo.schema.index')
                ->with('success', 'Schema markup deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting schema markup.');
        }
    }

    /**
     * Validate schema markup
     */
    public function validate(Request $request)
    {
        $request->validate([
            'schema_id' => 'required|exists:seo_schema_markups,id'
        ]);

        $schema = SchemaMarkup::findOrFail($request->schema_id);
        $result = $this->validateSchema($schema);

        if ($request->ajax()) {
            return response()->json($result);
        }

        return redirect()->back()->with(
            $result['valid'] ? 'success' : 'error',
            $result['message']
        );
    }

    /**
     * Get schema template for a specific type
     */
    public function getTemplate(Request $request)
    {
        $type = $request->get('type');
        $template = SchemaMarkup::getSchemaTemplate($type);

        return response()->json([
            'template' => $template,
            'formatted' => json_encode($template, JSON_PRETTY_PRINT)
        ]);
    }

    /**
     * Validate schema markup using Google's Structured Data Testing Tool
     */
    private function validateSchema(SchemaMarkup $schema)
    {
        try {
            $jsonLd = $schema->generateJsonLd();

            // Basic JSON validation
            $decoded = json_decode($jsonLd, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $schema->update([
                    'validation_status' => 'invalid',
                    'validation_errors' => ['Invalid JSON format: ' . json_last_error_msg()]
                ]);

                return [
                    'valid' => false,
                    'message' => 'Invalid JSON format',
                    'errors' => ['Invalid JSON format: ' . json_last_error_msg()]
                ];
            }

            // Check required fields based on schema type
            $errors = $this->validateSchemaStructure($decoded, $schema->type);

            if (empty($errors)) {
                $schema->update([
                    'validation_status' => 'valid',
                    'validation_errors' => null
                ]);

                return [
                    'valid' => true,
                    'message' => 'Schema markup is valid'
                ];
            } else {
                $schema->update([
                    'validation_status' => 'invalid',
                    'validation_errors' => $errors
                ]);

                return [
                    'valid' => false,
                    'message' => 'Schema markup has validation errors',
                    'errors' => $errors
                ];
            }

        } catch (\Exception $e) {
            $schema->update([
                'validation_status' => 'invalid',
                'validation_errors' => ['Validation error: ' . $e->getMessage()]
            ]);

            return [
                'valid' => false,
                'message' => 'Validation failed',
                'errors' => ['Validation error: ' . $e->getMessage()]
            ];
        }
    }

    /**
     * Validate schema structure based on type
     */
    private function validateSchemaStructure($data, $type)
    {
        $errors = [];

        // Common validations
        if (!isset($data['@context'])) {
            $errors[] = '@context is required';
        }
        if (!isset($data['@type'])) {
            $errors[] = '@type is required';
        }

        // Type-specific validations
        switch ($type) {
            case 'local_business':
                if (empty($data['name'])) $errors[] = 'Business name is required';
                if (empty($data['address'])) $errors[] = 'Address is required';
                break;

            case 'faq':
                if (empty($data['mainEntity'])) $errors[] = 'FAQ questions are required';
                break;

            case 'article':
                if (empty($data['headline'])) $errors[] = 'Article headline is required';
                if (empty($data['author'])) $errors[] = 'Article author is required';
                break;

            case 'product':
                if (empty($data['name'])) $errors[] = 'Product name is required';
                if (empty($data['offers'])) $errors[] = 'Product offers are required';
                break;

            case 'breadcrumb':
                if (empty($data['itemListElement'])) $errors[] = 'Breadcrumb items are required';
                break;
        }

        return $errors;
    }
}
