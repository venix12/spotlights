import React from 'react';

interface Props {
    pushAnswer: (question: Question, answer: string) => void,
    question: Question,
}

interface State {
    input: string,
}

class InputQuestion extends React.Component<Props, State> {
    state = {
        input: '',
    }

    handleChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        this.setState({ input: event.target.value });
        this.props.pushAnswer(this.props.question, event.target.value);
    }

    render() {
        const { question } = this.props;
        const { input } = this.state;

        return (
            <div className="d-block">
                {question.question}
                <input
                    type="text"
                    className="dark-form__input dark-form__input--small dark-form__input--left"
                    value={input}
                    onChange={this.handleChange}
                />
            </div>
        );
    }

    rowsCount = (): number => {
        return Math.round(this.props.question.char_limit / 100) + 2;
    }
}

export default InputQuestion;
