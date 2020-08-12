class Welcome extends React.Component
{
    constructor(props)
    {
        super(props);
        this.state = {
            name : this.props.name, 
            hiddenName : this.props.name,
            changeNameStyle : {}
        };

        this.textBoxChangedHandler = this.textBoxChangedHandler.bind(this);
        this.buttonClickedHandler = this.buttonClickedHandler.bind(this);
    }

    textBoxChangedHandler(e)
    {
        this.setState({hiddenName : e.target.value});
    }

    buttonClickedHandler(e)
    {
        this.setState((state) => ({name : state.hiddenName}));

        if (this.state.hiddenName != undefined)
        {
            this.setState({changeNameStyle : {display : "none"}});
        }
    }

    render()
    {
        return (
            <div style={this.props.style}>
                Welcome {this.state.name}
                <div style={this.state.changeNameStyle}>
                    <input onChange={this.textBoxChangedHandler}/>
                    <input type="button" value="Change Name" onClick={this.buttonClickedHandler}/>
                </div>
            </div>
        );
    }
}

const style = {
    "color": "black",
    "clear": "left",
    "font-size" : "20px"
};

ReactDOM.render(<Welcome style={style}/>, document.getElementById("welcome"));