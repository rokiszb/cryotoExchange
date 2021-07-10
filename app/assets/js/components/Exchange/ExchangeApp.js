import React, { Component } from 'react';

export default class ExchangeApp extends Component {
    constructor(props) {
        super(props);
        this.state = { amount: '', from: '', to: '' };
    }
    myFromHandler = (event) => {
        this.setState({from: event.target.value});
    }
    myToHandler = (event) => {
        this.setState({to: event.target.value});
    }
    myAmountHandler = (event) => {
        this.setState({amount: event.target.value});
    }

    mySubmitHandler = (event) => {
        event.preventDefault();
        const requestData = {
            amount: this.state.amount,
            from: this.state.from,
            to: this.state.to,
            converted: this.state.converted,
        };
        fetch(`/api/exchange/${requestData.from}-${requestData.to}?amount=${requestData.amount}`)
            .then(res => res.json())
            .then(
                (result) => {
                    console.log(result.rates)
                    let to = this.state.to;
                    this.setState({converted: result.rates[to]})
                },
                (error) => {
                    this.setState({
                        isLoaded: true,
                        error
                    });
                }
            );
    }
    render() {
        return (
            <form className="col-lg-6 offset-lg-3 " onSubmit={this.mySubmitHandler}>
                <div className="row justify-content-center">
                    <h1>Exchange rate</h1>
                    <div className="mb-3">
                        <label htmlFor="from" className="form-label">From</label>
                        <input type="text" className="form-control" id="from" placeholder="From" value={this.state.from} onChange={this.myFromHandler}/>
                    </div>
                    <div className="mb-3">
                        <label htmlFor="to" className="form-label">To</label>
                        <input type="text" className="form-control" id="to" placeholder="To" value={this.state.to} onChange={this.myToHandler}/>
                    </div>
                    <div className="mb-3">
                        <label htmlFor="amount" className="form-label">Amount</label>
                        <input type="text" className="form-control" id="amount" placeholder="Amount" value={this.state.amount} onChange={this.myAmountHandler}/>
                    </div>
                    <div className="mb-3">
                        <label htmlFor="converted" className="form-label">Converted amount</label>
                        <input type="text" readOnly className="form-control" id="converted" placeholder="" value={this.state.converted}/>
                    </div>
                    <input
                        type='submit'
                        className={'btn btn-primary'}
                    />
                </div>
            </form>
        );
    }
}