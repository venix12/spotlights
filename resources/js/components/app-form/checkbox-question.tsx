import React from 'react';

interface Props {
    displayOrHideChildren: (question: Question, value: string) => void,
    pushAnswer: (question: Question, answer: string) => void,
    question: Question,
}

class CheckboxQuestion extends React.Component<Props> {
    handleChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        const { question } = this.props;

        if (question.relation === 'parent' && question.children) {
            this.props.displayOrHideChildren(question, event.target.value);
        }

        this.props.pushAnswer(question, event.target.value);
    }

    render() {
        const { question } = this.props;

        return (
            <>
                <div className="app-form__radio-question">
                    {question.question}
                    <div className="app-form__description">
                        {question.description}
                    </div>
                </div>

                <div className="app-form__radio-container">
                    <div className="app-form__radio">
                        <input type="radio" id={`true-${question.id}`} name={`${question.id}`} value="true" onChange={this.handleChange} />
                        <label htmlFor={`true-${question.id}`}>Yes</label>
                    </div>

                    <div className="app-form__radio">
                        <input type="radio" id={`false-${question.id}`} name={`${question.id}`} value="false" onChange={this.handleChange} />
                        <label htmlFor={`false-${question.id}`}>No</label>
                    </div>
                </div>
            </>
        )
    }
}

export default CheckboxQuestion;
