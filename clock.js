console.log("Hello world!");

function tick()
{
    console.log("here");
    const element = (
        <div>
            <h1>Hello World</h1>
        </div>
    );

    ReactDOM.render(element, document.getElementById('clock'));
}

setInterval(tick, 1000);