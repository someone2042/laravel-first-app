<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>AI Chat Bot (Tailwind)</title>
    <!-- 1. Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Optional: Configure Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Assuming you have a custom color 'laravel'
                        // If not, remove this or define your color
                        laravel: '#ef3b2d', // Example color
                    },
                }
            }
        }
    </script>

    <!-- 2. Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Optional: Custom scrollbar styling (add to a <style> tag or separate CSS file) -->
    <style>
        /* Custom scrollbar for WebKit browsers */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #aaa;
        }

        /* Basic resize none for textarea */
        textarea {
            resize: none;
        }
    </style>
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- Your Provided Navbar Structure -->
    <nav class="flex justify-between items-center bg-white">
        <a href="/"><img class="w-24" src="{{ asset('images/logo.png') }}" alt="" class="logo" /></a>
        <ul class="flex space-x-6 mr-6 text-lg">
            @auth
                <span class="font-bold uppercase">
                    Welcom {{ auth()->user()->name }}
                </span>
                <li>
                    <a href="/listings/manage" class="hover:text-laravel"><i class="fa-solid fa-gear"></i>
                        ManageListings</a>
                </li>
                <li>
                    <form class="inline" method="POST" action="/logout">
                        <input type="hidden" name="_token" value='{{ csrf_token() }}'>
                        <button type="submit">
                            <i class="fa-solid fa-door-closed"></i>
                            logout
                        </button>
                    </form>
                </li>
            @else
                <li>
                    <a href="/register" class="hover:text-laravel"><i class="fa-solid fa-user-plus"></i> Register</a>
                </li>
                <li>
                    <a href="/login" class="hover:text-laravel"><i class="fa-solid fa-arrow-right-to-bracket"></i>
                        Login</a>
                </li>
            @endauth
        </ul>
    </nav>

    <!-- Main Chat Container -->
    <main class="flex justify-center items-center flex-grow px-4">
        <div
            class="w-full max-w-4xl h-[80vh] max-h-[650px] bg-white rounded-lg shadow-xl flex flex-col border border-gray-200 overflow-hidden">

            <!-- Chat Header -->
            {{-- <div
                class="bg-blue-600 text-white p-4 flex items-center justify-between border-b border-blue-700 flex-shrink-0">
                <h2 class="text-lg font-semibold">AI Assistant</h2>
                <span class="h-3 w-3 bg-green-400 rounded-full"></span> <!-- Status Indicator -->
            </div> --}}

            <!-- Chat Messages Area -->
            <div id="chat-messages"
                class="flex-grow text-sm p-4 md:p-6 space-y-4 overflow-y-auto bg-gray-50 custom-scrollbar">
                <!-- Example Messages -->
                <div class="message hidden"></div>
                {{-- <div class="flex message">
                    <div class="bg-gray-200 text-gray-800 py-2 px-4 rounded-xl rounded-bl-lg max-w-[75%]">
                        <span class="chattext">Hello! How can I help you today?</span>
                    </div>
                </div>

                <div class="flex justify-end message">
                    <div class="bg-blue-500 text-white py-2 px-4 rounded-xl rounded-br-lg max-w-[75%]">
                        <span class="chattext">Hi! I need help understanding Tailwind CSS Flexbox.</span>
                    </div>
                </div>

                <div class="flex message">
                    <div class="bg-gray-200 text-gray-800 py-2 px-4 rounded-xl rounded-bl-lg max-w-[75%]">
                        <span class="chattext">Sure! Flexbox in Tailwind uses classes like `flex`, `items-*`,
                            `justify-*` to control
                            layout. What specifically are you struggling with?
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perspiciatis consectetur
                            reiciendis dolorum consequatur dicta modi cupiditate laudantium commodi, pariatur amet
                            blanditiis neque asperiores illo nihil vitae repudiandae magnam. Consequuntur, fugit?
                            Sapiente minus, necessitatibus delectus quaerat laborum ut quas quo et nemo maxime expedita
                            magnam ab nihil odit officiis laboriosam amet fugit rerum! Eveniet doloribus dolores sunt
                            officia maiores non consectetur.
                            Unde recusandae quis minima porro dolore facilis. Qui asperiores esse aperiam pariatur non
                            dolor itaque minus? Optio eum suscipit reiciendis, officia atque repudiandae aut ea
                            molestiae delectus nam, doloribus expedita?</span>
                    </div>
                </div> --}}
                <!-- More messages will be added here -->
            </div>

            <!-- Chat Input Area -->
            <div class="p-4 border-t border-gray-200 bg-white flex items-end space-x-2 flex-shrink-0">
                <textarea id="user-input"
                    class="flex-grow border border-gray-300 rounded-lg resize-none py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent text-sm max-h-24"
                    placeholder="Type your message..." rows="1"></textarea>
                <button id="send-button"
                    class="bg-blue-500 hover:bg-blue-600 text-white rounded-full h-10 w-10 flex items-center justify-center flex-shrink-0 transition-colors duration-200 ease-in-out disabled:bg-gray-300 disabled:cursor-not-allowed">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>

        </div>
    </main>

    <!-- Add your JavaScript file here for functionality -->
    <!-- <script src="script.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/showdown@2.1.0/dist/showdown.min.js"></script>
    <script>
        var converter = new showdown.Converter()
        // Basic auto-resize for textarea (optional)
        const textarea = document.getElementById('user-input');
        textarea.addEventListener('input', () => {
            textarea.style.height = 'auto'; // Reset height
            textarea.style.height = `${textarea.scrollHeight}px`; // Set to scroll height
            // Prevent excessive growth (optional)
            if (textarea.scrollHeight > 96) { // 96px ~ max-h-24
                textarea.style.overflowY = 'auto';
            } else {
                textarea.style.overflowY = 'hidden';
            }
        });

        // Example: Disable send button if input is empty
        const sendButton = document.getElementById('send-button');
        textarea.addEventListener('input', () => {
            sendButton.disabled = textarea.value.trim() === '';
        });
        // Initial check
        sendButton.disabled = textarea.value.trim() === '';
    </script>
    <script>
        $("#send-button").click(function(event) {
            let val = $('#user-input').val();
            let valHTML = `<div class="flex justify-end message thing">
                    <div class="bg-blue-500 text-white py-2 px-4 rounded-xl rounded-br-lg max-w-[75%]">
                        <span class="chattext">` + val + `</span>
                    </div>
                </div>`
            console.log(valHTML);
            $(".message").last().after(valHTML);
            $('#user-input').val('');
            let texts = [];
            $(".thing").each(function() {
                texts.push($(this).text());
            });
            console.log(texts);
            $.ajax({
                url: "/ai",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    text: texts,
                }
            }).done(function(res) {
                console.log(res);
                let text = converter.makeHtml(res.responseData);
                let html = `
                <div class="flex message thing">
                    <div class="bg-gray-200 text-gray-800 py-2 px-4 rounded-xl rounded-bl-lg max-w-[75%]">
                        <span class="chattext">` + text + `</span>
                    </div>
                </div>`
                $(".message").last().after(html);
                const elements = document.querySelectorAll(".message");
                const lastElement = elements[elements.length - 1];
                lastElement.scrollIntoView();
                // hljs.highlightAll();

            });
        })
    </script>

</body>

</html>
