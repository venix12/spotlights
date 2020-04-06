import React from 'react';

interface Props {
    displayOrHideChildren: (question: Question, value: string) => void,
    pushAnswer: (question: Question, answer: string) => void,
    question: Question,
}

class CheckboxQuestion extends React.Component<Props> {
    handleChange = (event: React.ChangeEvent<HTMLSelectElement>) => {
        const { question } = this.props;

        if (question.relation === 'parent' && question.children) {
            this.props.displayOrHideChildren(question, event.target.value);
        }

        this.props.pushAnswer(question, event.target.value);
    }

    render() {
        const { question } = this.props;

        return (
            <div className="d-block">
                {question.question}
                <select className="dark-form__select dark-form__select--left dark-form__select--bottom" onChange={this.handleChange} required>
                    <option value="">Select an answer!</option>
                    <option value="true">Yes</option>
                    <option value="false">No</option>
                </select>
            </div>
        )
    }
}

export default CheckboxQuestion;
