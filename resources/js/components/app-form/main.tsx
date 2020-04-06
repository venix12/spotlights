import React, { FormEvent } from 'react';
import { render } from '../../helpers/render';
import { parseJson, gamemode } from '../../helpers/helpers';
import TextareaQuestion from './textarea-question';
import CheckboxQuestion from './checkbox-question';
import InputQuestion from './input-question';
import Axios from 'axios';
import { Alert } from '../alert';

interface Answer {
    id: number,
    answer: string,
}

interface Props {
    availableModes: string[],
    questions: Question[],
}

interface State {
    answers: Answer[],
    gamemode: string,
    message: string[],
    questions: Question[],
}

class Main extends React.Component<Props, State> {
    state = {
        answers: [{id: 0, answer: ''}],
        gamemode: '',
        message: [],
        questions: this.props.questions.filter(x => x.relation !== 'child'),
    }

    closeMessage = () => {
        this.setState({ message: [] });
    }

    displayOrHideChildren = (question: Question, value: string): void => {
        const { questions } = this.state;

        if (value === 'true') {
            const joined = questions
                .concat(question.children!)
                .sort((x, y) => x.order - y.order);

            this.setState({ questions: joined });
        } else {
            const hidden = questions.filter(x => !question.children!.includes(x));

            this.setState({ questions: hidden });
        }
    }

    handleModeChange = (event: React.ChangeEvent<HTMLSelectElement>) => {
        this.setState({ gamemode: event.target.value });
    }

    pushAnswer = (question: Question, answer: string) => {
        const { answers } = this.state;

        const answerObject: Answer = { id: question.id, answer: answer };

        let joined: Answer[];

        if (answers.find(x => x.id === answerObject.id) == null) {
            joined = answers.concat(answerObject);
        } else {
            joined = answers.slice();
            joined.find(x => x.id === question.id)!.answer = answerObject.answer;
        }

        this.setState({ answers: joined });
    }

    render() {
        const { availableModes } = this.props;
        const { message, questions } = this.state;

        return (
            <div>
                <div className="dark-section dark-section--3">
                    <div className="d-flex justify-content-center">
                        What game mode do you want to curate for?
                        <select className="dark-form__select dark-form__select--left" onChange={this.handleModeChange} required>
                            <option value="">Select gamemode</option>
                            {availableModes.map((mode, index) => {
                                return <option value={mode} key={index}>{gamemode(mode)}</option>
                            })}
                        </select>
                    </div>
                </div>

                <form onSubmit={this.storeApplication}>
                    <div  className="dark-section dark-section--4">
                        {questions.map(question => {
                            return this.renderQuestion(question);
                        })}
                    </div>

                    <div className="dark-section dark-section--3">
                        <div className="d-flex justify-content-center">
                            <button type="submit" className="dark-form__button dark-form__button--bottom">
                                <i className="fa fa-user" /> Apply now!
                            </button>
                        </div>

                        <div className="d-flex justify-content-center">
                            {message[0] && <Alert closeVar={this.closeMessage} type={message[0]} message={message[1]}/>}
                        </div>
                    </div>
                </form>
            </div>
        );
    }

    renderQuestion(question: Question): JSX.Element {
        switch (question.type) {
            case 'checkbox':
                return <CheckboxQuestion
                    pushAnswer={this.pushAnswer}
                    displayOrHideChildren={this.displayOrHideChildren}
                    question={question} key={question.id}
                />;

            case 'input':
                return <InputQuestion pushAnswer={this.pushAnswer} question={question} key={question.id}/>

            case 'section':
                return this.renderSection(question);

            case 'textarea':
                return <TextareaQuestion pushAnswer={this.pushAnswer} question={question} key={question.id}/>;
        }
    }

    renderSection(question: Question) {
        return (
            <div className="section-header section-header--bottom" key={question.id}>
                <div className="section-header__header">{question.question}</div>
                <div className="section-header__description">{question.description}</div>
            </div>
        );
    }

    storeApplication = async (event: FormEvent<HTMLFormElement>) => {
        const { answers, gamemode, questions } = this.state;
        event.preventDefault();

        const answerableQuestionsCount = questions.filter(x => x.type !== 'section').length;

        const validQuestionsIds = questions.map(x => x['id']);
        const validAnswersCount = answers
            .filter(x => validQuestionsIds.includes(x.id) === true)
            .filter(x => x.answer !== '')
            .length;

        if (gamemode === '') {
            this.setState({ message: ['error', 'You need to select a gamemode!']});

            return;
        }

        if (answerableQuestionsCount !== validAnswersCount) {
            this.setState({ message: ['error', 'You need to answer to all of the questions!']});

            return;
        }

        const response = await Axios.post(laroute.route('app.store'), {
            answers: answers.filter(x => x.id !== 0),
            gamemode: gamemode,
        });

        if (response.data[0] === 'error') {
            this.setState({ message: ['error', response.data[1]]});
        } else {
            this.setState({ message: ['success', 'Successfully submitted an application!']});
        }
    }
}

render('app-form', Main, {
    availableModes: parseJson('json-modes'),
    questions: parseJson('json-questions'),
});
