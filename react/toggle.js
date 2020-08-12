class Toggle extends React.Component
{
    constructor(props)
    {
        super(props);
        this.state = {isToggleOn : true};

        this.clickedHandler = this.clickedHandler.bind(this);
    }

    clickedHandler(e)
    {
        this.setState((state) => (
            {isToggleOn : (state.isToggleOn ? false : true)}
        ))
    }

    render()
    {
        return (
            <div>
                {this.state.isToggleOn ? 'ON' : 'OFF'}
                <button onClick={this.clickedHandler} style={{"margin-left" : "5px"}}>Toggle</button>
            </div>
        );
    }
}

ReactDOM.render(<Toggle/>, document.getElementById("toggle"));