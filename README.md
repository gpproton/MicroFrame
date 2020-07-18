# Quick parts

`use \MicroFrame\Core\Controller as Core;

/**
 * Class TestController
 * @package App\Controller
 */
class TestController extends Core {

    /**
     * Controller index method, normal.
     */
    public function index()
    {
        /**
         * Set if controller should auto or not via it's path.
         */
        $this->auto(false);

        $this->response
            // Optional set method
            ->methods(['get', 'post'])
            // It's optional but why, I don't remember.
            ->data(['villains' => ['Black Beard', 'Douglass Bullet', 'D Rocks', 'Im Sama']])
            // Set optional formats application/json | application/xml no etc for now.
            ->format("application/xml")
            // Hmm, yeah optional middleware, nothing magical I guess if they all return true.
            ->middleware(['default', 'companya.easyAuth', 'customApp.validation'])
            // Optional status stuff
            ->status(200)
            // Required.
            ->send();
    }
}`

## Why Bother with MicroFrame

Yeah i know it's not a very creative name and does suck, hmm not a very good joke of how the joke goes since it needs explanation to cut it short simplistic micro plain framework with a little touch of q[M]VC.

I case you feel there's any deficiency, or an enhancement required in the code please message me also teach me anything.

In case you still not getting the q[M]VC it's query and parameters in a fancy file/class, but I bet you'll not hate it too much, and it works, and the other i guess are somewhat normal stuff maybe except the Task, Routing and any other stuff you do notice, hopefully they're working while you use it.

NOTE: I can never dream for now this can replace your laravel, fuelPhp or codeIgniter4 as i love those PHP framework especially codeIgniter4 but MicroFrame exist to for a different purpose.

**First make me less bored

**Secondly I get to write my name on stuff, try it "FEELS GOOD".

Serious reason -> Do lot stuff super quick, except models [not everyone use models, i know lot of old systems] again with the need reiterate, 
