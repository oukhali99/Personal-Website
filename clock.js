function tick()
{
    console.log("here");    
    const element = (
        <div>
            <h1>Hello World</h1>
            <h2>It is {new Date().toLocaleDateString()}.</h2>
        </div>
    );

    ReactDOM.render(element, document.getElementById('clock'));
}

setInterval(tick, 1000);