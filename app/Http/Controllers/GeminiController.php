<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\TryCatch;

class GeminiController extends Controller
{
    //
    public function index()
    {
        return view('geminiindex');
    }
    public function send(Request $request)
    {
        //code...
        $apiKey = env('GOOGLE_API_KEY', '');
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";


        try {
            //code...
            $requestData = [
                "contents" => [
                    [
                        "role" => "user",
                        "parts" => [
                            ["text" => 'you are an AI assistant integrated into the \' Connexion Pro \' web platform . Your Purpose: Your primary goal is to help users effectively use the Connexion Pro platform. Connexion Pro is a marketplace designed to connect: Employers/Clients: Those who post job offers and project opportunities. Job Seekers/Freelancers: Those looking for work opportunities. Platform Functionality You Should Know About: Browsing Listings: Users can view a list of available jobs and projects on the main page (/). Searching Listings: Users can search for specific listings, likely using keywords, categories, locations, etc. (Explain how if there\'s a specific search bar/page). Viewing Listings: Users can click on a listing to see its details. User Accounts: Users need to register (/register) and log in (/login) to access certain features. Guest users have limited access. Posting Listings: Authenticated (logged-in) users can create new job or project posts via a specific form (/listings/create). Managing Listings: Authenticated users can view, edit (/listings/{id}/edit), and delete (/listings/{id} -> DELETE) their own postings, likely through a dashboard or \'Manage Listings\' page (/listings/manage). Authentication: Users can log out (/logout). Your Role - How to Help Users: Finding Opportunities: Help users formulate searches or understand how to use the search/filter tools to find relevant jobs or projects on this platform. You can ask clarifying questions about what they are looking for (e.g., "What type of job are you looking for?", "Which location?"). Posting Opportunities: Guide authenticated users on how to create and post a new listing. Explain the necessary steps or direct them to the correct page (/listings/create). Platform Navigation & Usage: Answer questions about how to perform specific actions on Connexion Pro (e.g., "How do I edit my job post?", "Where can I see the jobs I posted?", "How do I register?"). Explaining Features: Clarify what different parts of the platform do. Important Guidelines: Focus: Keep your responses centered on using the Connexion Pro platform. Accuracy: Base your instructions on the actual features described above. Guidance, Not Action: Guide users on how to do things; you cannot perform actions for them (like posting a job or applying). Authentication: Remember that posting, editing, and managing listings require the user to be logged in. Remind them if necessary. Limitations: Do not provide general career advice, write resumes/cover letters, or discuss topics unrelated to finding/posting jobs/projects on this specific platform. If asked something outside your scope, politely state that you are here to help with using Connexion Pro. Tone: Be helpful, clear, professional, and encouraging. By understanding these details, you can effectively assist users navigating and utilizing the Connexion Pro platform.']
                        ]
                    ],
                    [
                        "role" => "model",
                        "parts" => [
                            ["text" => "Understood. \n"]
                        ]
                    ],

                ],
                "tools" => [
                    [
                        "functionDeclarations" => [
                            [
                                "name" => "getListings",
                                "description" => "Searches the job/project database for listings matching the provided criteria.",
                                "parameters" => [
                                    "type" => "object",
                                    "properties" => [
                                        "keywords" => [
                                            "type" => "array",
                                            "items" => [
                                                "type" => "string"
                                            ],
                                            "description" => "A list of relevant keywords extracted from the user's input, such as skills, job titles, technologies, qualifications, or specific requirements."
                                        ]
                                    ]
                                ]
                            ],
                        ]
                    ],
                ],
                "generationConfig" => [
                    "temperature" => 2,
                    "topK" => 64,
                    "topP" => 0.95,
                    "maxOutputTokens" => 8192,
                    "stopSequences" => []
                ],

                "safetySettings" => [
                    [
                        "category" => "HARM_CATEGORY_HARASSMENT",
                        "threshold" => "BLOCK_NONE"
                    ],
                    [
                        "category" => "HARM_CATEGORY_HATE_SPEECH",
                        "threshold" => "BLOCK_NONE"
                    ],
                    [
                        "category" => "HARM_CATEGORY_SEXUALLY_EXPLICIT",
                        "threshold" => "BLOCK_NONE"
                    ],
                    [
                        "category" => "HARM_CATEGORY_DANGEROUS_CONTENT",
                        "threshold" => "BLOCK_NONE"
                    ]
                ]
            ];
            $sender = 'user';
            foreach ($request->text as $message) {

                $newElement = [
                    "role" => $sender,
                    "parts" => [
                        ["text" => $message]
                    ]
                ];
                $requestData["contents"][] = $newElement;
                if ($sender == 'user') {
                    $sender = 'model';
                } else {
                    $sender = 'user';
                }
            }
            // return response()->json(['requestData' =>  $requestData["contents"]]);
        } catch (\Throwable $th) {

            return response()->json(['error1' => "An unexpected error occurred: " . $th->getMessage() . " in " . $th->getFile() . " on line " . $th->getLine()]);
        }

        try {
            // return response()->json(['error' => $requestData]);
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post($apiUrl, $requestData);
        } catch (\Throwable $th) {
            return response()->json(['error2' => "An unexpected error occurred: " . $th->getMessage() . " in " . $th->getFile() . " on line " . $th->getLine()]);
        }
        try {
            if ($response->successful()) {
                // Request was successful
                $responseData = $response->json();
                // return response()->json(['responseData' =>  $responseData]);
                if (isset($responseData['candidates'][0]['content']['parts'][0]['functionCall'])) {
                    $city = $responseData['candidates'][0]['content']['parts'][0]['functionCall']['args']['city'];
                    // implimentation of function
                    // return response()->json('wooork');
                    // return call
                    $newElement = [
                        "role" => 'model',
                        "parts" => [
                            [
                                "functionCall" => [
                                    "name" => 'getWeather',
                                    "args" => $responseData['candidates'][0]['content']['parts'][0]['functionCall']['args']
                                ]
                            ]
                        ]
                    ];
                    $requestData["contents"][] = $newElement;

                    $newElement = [
                        "role" => 'user',
                        "parts" => [
                            [
                                "functionResponse" => [
                                    "name" => 'getWeather',
                                    "response" => [
                                        // This structure depends on what your 'getWeather' tool is defined to return
                                        // If it returns a simple string, use a key like 'weather_data'
                                        "weather_data" => 'Currently 32 degrees celsius'
                                        // If your tool returns complex data, structure it here
                                        // e.g., "temperature": 32, "unit": "celsius", "condition": "sunny"
                                    ]
                                ]
                            ]
                        ]
                    ];

                    $requestData["contents"][] = $newElement;
                    try {
                        // return response()->json(['error' => $requestData]);
                        $response2 = Http::withHeaders([
                            'Content-Type' => 'application/json'
                        ])->post($apiUrl, $requestData);
                    } catch (\Throwable $th) {
                        return response()->json(['error10' => "An unexpected error occurred: " . $th->getMessage() . " in " . $th->getFile() . " on line " . $th->getLine()]);
                    }
                    if ($response2->successful()) {
                        // return response()->json(['dooone']);
                        $finalResponseData = $response2->json();
                        $finalTextResponse = $finalResponseData['candidates'][0]['content']['parts'][0]['text'];
                        return response()->json(['responseData' =>  $finalTextResponse]);
                    }
                } elseif (isset($responseData['candidates'][0]['content']['parts'][1]['functionCall']['name'])  && $responseData['candidates'][0]['content']['parts'][1]['functionCall']['name'] == 'getWeather') {
                    $city = $responseData['candidates'][0]['content']['parts'][1]['functionCall']['args']['city'];
                    // implimentation of function

                    // return call
                    $newElement = [
                        "role" => 'model',
                        "parts" => [
                            [
                                "functionCall" => [
                                    "name" => 'getWeather',
                                    "args" => $responseData['candidates'][0]['content']['parts'][1]['functionCall']['args']
                                ]
                            ]
                        ]
                    ];
                    $requestData["contents"][] = $newElement;

                    $newElement = [
                        "role" => 'user',
                        "parts" => [
                            [
                                "functionResponse" => [
                                    "name" => 'getWeather',
                                    "args" => '32 degrees celsius'
                                ]
                            ]
                        ]
                    ];

                    $requestData["contents"][] = $newElement;
                    try {
                        // return response()->json(['error' => $requestData]);
                        $response = Http::withHeaders([
                            'Content-Type' => 'application/json'
                        ])->post($apiUrl, $requestData);
                        return response()->json(['responseFunction1' =>  $response]);
                    } catch (\Throwable $th) {
                        return response()->json(['error13' => "An unexpected error occurred: " . $th->getMessage() . " in " . $th->getFile() . " on line " . $th->getLine()]);
                    }
                } else {
                    $fullResponseData = $responseData;
                    $responseData = $responseData['candidates'][0]['content']['parts'][0]['text'];
                    $encodedResponse = $responseData;
                    // Process the response from Gemini API
                    return response()->json(['responseData' => $encodedResponse, 'requestData' =>  $requestData, 'fullResponseData3' => $fullResponseData]);
                    // dd($responseData);
                }
            } else {
                // Handle errors (e.g., log, display message)
                return response()->json(['error4' => $response->status()]);
                Log::error('Gemini API request failed: ' . $response->status());
                // dd($response);
            }
        } catch (\Throwable $th) {
            return response()->json(['error5' => "An unexpected error occurred: " . $th->getMessage() . " in " . $th->getFile() . " on line " . $th->getLine()]);
        }
    }
}
