use Illuminate\Http\Request;
use WidowsXP\Post;
use WidowsXP\Page;

class SearchController extends Controller {
	
	public function index(Request $request) {
		$query = $request->get('query');
		$users = Users::where('name' 'LIKE', "%query%")->get();
		return view('results', compact('users'));
	}

}
