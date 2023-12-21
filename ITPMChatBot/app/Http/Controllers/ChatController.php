<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use OpenAI\Laravel\Facades\OpenAI;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\User;
use App\Models\AiChatHistory;
use App\Models\UsersChatHistory;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function newAiChat($chatId = null)
    {   
        if(Auth::user()->user_type == 'admin'){
            return back();
        }

        $getUsers=User::select('*')
        ->where('id','!=',Auth::id())
        ->get();

        $getAiChatHistoryList=AiChatHistory::select('*', DB::raw('MAX(created_at) as latest_message_time'))
        ->where('user_id','=',Auth::id())
        ->groupBy('chat_id')
        ->orderBy('latest_message_time','desc')
        ->get();

        $getAiChatHistory=AiChatHistory::select('*')
        ->where('user_id','=',Auth::id())
        ->where('chat_id', '=', $chatId)
        ->orderBy('created_at','asc')
        ->get();

        return view('chat.aichat')
               ->with('users',$getUsers)
               ->with('aichathistorylist',$getAiChatHistoryList)
               ->with('aichathistories',$getAiChatHistory);
    }

    function getAiChat($chatId)
    {
        if(Auth::user()->user_type == 'admin'){
            return back();
        }
        
        $getUsers=User::select('*')
        ->where('id','!=',Auth::id())
        ->get();

        $getAiChatHistoryList=AiChatHistory::select('*', DB::raw('MAX(created_at) as latest_message_time'))
        ->where('user_id','=',Auth::id())
        ->groupBy('chat_id')
        ->orderBy('latest_message_time','desc')
        ->get();

        $getAiChatHistory=AiChatHistory::select('*')
        ->where('user_id','=',Auth::id())
        ->where('chat_id', '=', $chatId)
        ->orderBy('created_at','asc')
        ->get();

        return view('chat.aichat')
               ->with('users',$getUsers)
               ->with('aichathistorylist',$getAiChatHistoryList)
               ->with('aichathistories',$getAiChatHistory);
    }

    function userChat($userId)
    {   
        if(Auth::user()->user_type == 'admin'){
            return back();
        }
        
        $getUsers=User::select('*')
        ->where('id','!=',Auth::id())
        ->get();

        $getAiChatHistoryList=AiChatHistory::select('*', DB::raw('MAX(created_at) as latest_message_time'))
        ->where('user_id','=',Auth::id())
        ->groupBy('chat_id')
        ->orderBy('latest_message_time','desc')
        ->get();

        $getUsersChatHistory=UsersChatHistory::select('*')
        ->where(function ($query) use ($userId) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $userId);
        })
        ->orWhere(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', Auth::id());
        })
        ->orderBy('created_at','asc')
        ->get();

        return view('chat.userchat')
               ->with('users',$getUsers)
               ->with('aichathistorylist',$getAiChatHistoryList)
               ->with('userschathistories',$getUsersChatHistory)
               ->with(compact('userId'));
    }
    
    public function response(Request $request){
        $prompt = $request->input;
        
        if($request->chatId === '' || $request->chatId === null){
            $chatId = strtoupper(substr(md5(uniqid()), 0, 8));
            $chatTitle = $prompt;
        }else{
            $chatId = $request->chatId;
            $chatTitle = $request->chatTitle;
        }

        AiChatHistory::create([
            'user_id' => Auth::id(),
            'message' => $prompt,
            'chat_id' => $chatId,
            'chat_title' => $chatTitle,
            'source' => 'user',
        ]);
        
        $pdfFilePath = public_path('files/Chapter1.pdf');
    
        if (file_exists($pdfFilePath)) {
            $parser = new Parser();
            $pdf    = $parser->parseFile($pdfFilePath);
    
            $text = '';
            foreach ($pdf->getPages() as $page) {
                $text .= $page->getText();
            }
        }

        $prompt = $text.'. Base on the chapter answer my question(s), '.$request->input;
        $prompt = $prompt.'. If it doesn\'t including my question(s), ';
        $prompt = $prompt.'answer Sorry, I can\'t answer your question(s).';

        $result = OpenAI::chat()->create([
            'max_tokens' => 400,
            'model' => 'gpt-3.5-turbo-1106',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        $response = $result->choices[0]->message->content;
        
        AiChatHistory::create([
            'user_id' => Auth::id(),
            'message' => $response,
            'chat_id' => $chatId,
            'chat_title' => $chatTitle,
            'source' => 'ai',
        ]);
        
        return $chatId;
    }

    public function renameAiChat($chatId){
        $request = request();
        $renameAiChat=AiChatHistory::select('*')
        ->where('chat_id', '=', $chatId)
        ->get();
        
        foreach ($renameAiChat as $chat) {
            $chat->chat_title = $request->newTitle;
            $chat->save();
        }
        
        return redirect()->route('aiChat');
    }

    public function deleteAiChat($chatId){
        $deleteAiChat=AiChatHistory::select('*')
        ->where('chat_id', '=', $chatId)
        ->get();
        $deleteAiChat->each->delete();
        
        return redirect()->route('aiChat');
    }

    public function send(Request $request){
        $receiverId = $request->userId;
        $send = $request->input;

        UsersChatHistory::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'message' => $send,
        ]);
        
        return $receiverId;
    }

    public function tts($id){
        try {
            $findId = AiChatHistory::findOrFail($id);
    
            // Use the content of the 'message' property as input for TTS
            $input = $findId->message;
    
            $speech = OpenAI::audio()->speech([
                'model' => 'tts-1-hd',
                'input' => $input,
                'voice' => 'alloy',
            ]);
    
            file_put_contents(public_path('tts/speech.mp3'), $speech);
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error($e);
    
            // Return a response indicating the failure
            return response()->json(['success' => false, 'error' => 'Internal Server Error'], 500);
        }
    }
}
