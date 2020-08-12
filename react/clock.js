class Clock extends React.Component
{
    constructor(props)
    {
        super(props);
        this.state = {date : new Date()};
    }

    componentDidMount()
    {
        this.timerID = setInterval(
            () => this.tick(),
            1000
        );
    }

    componentWillUnmount()
    {
        clearInterval(this.timerID);
    }

    tick()
    {
        this.setState((state, props) => ({date : new Date()}))
    }

    render()
    {
        return (
            <div>
                <FormattedHMSTime date={this.state.date}/>
            </div>
        );
    }
}

class FormattedHMSTime extends React.Component
{
    render()
    {
        var date = this.props.date;
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var seconds = date.getSeconds();
        var output = "";

        if (hours < 10)
        {
            output += "0";
        }
        output += hours;
        output += ":";

        if (minutes < 10)
        {
            output += "0";
        }
        output += minutes;
        output += ":";

        if (seconds < 10)
        {
            output += "0";
        }
        output += seconds;

        return output;
    }
}

ReactDOM.render(<Clock/>, document.getElementById('clock'));
