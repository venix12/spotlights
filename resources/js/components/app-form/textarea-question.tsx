import React from 'react';

interface Props {
    pushAnswer: (question: Question, answer: string) => void,
    question: Question,
}

interface State {
    input: string,
}

class TextareaQuestion extends React.Component<Props, State> {
    state = {
        input: '',
    }

    handleChange = (event: React.ChangeEvent<HTMLTextAreaElement>) => {
        this.setState({ input: event.target.value });
        this.props.pushAnswer(this.props.question, event.target.value);
    }

    render() {
        const { question } = this.props;
        const { input } = this.state;

        return (
            <div className="info-panel">
                <div className="info-panel__header">{question.question}</div>
                <textarea
                    className="dark-form__textarea"
                    rows={this.rowsCount()}
                    maxLength={question.char_limit}
                    onChange={this.handleChange}
                    value={input}
                />
                <div className="info-badge">{input.length} / {question.char_limit}</div>
            </div>
        );
    }

    rowsCount = (): number => {
        return Math.round(this.props.question.char_limit / 100) + 2;
    }
}

export default TextareaQuestion;
