import React from 'react';
import Modal from './modal';
import Axios from 'axios';
import AppResultsMessage from './app-results-message';
import Linkify from 'react-linkify';


interface Props {
    application: Application,
}

interface State {
    approved?: boolean,
    feedback?: string,
    feedback_author?: User,
    modal: boolean,
    showFeedbackPm: boolean,
    verdict?: 'fail' | 'pass',
}

class AppCard extends React.Component<Props, State> {
    state = {
        approved: this.props.application.approved,
        feedback: this.props.application.feedback,
        feedback_author: this.props.application.feedback_author,
        modal: false,
        showFeedbackPm: false,
        verdict: this.props.application.verdict,
    }

    approveFeedback = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        Axios.post(
            laroute.route(
                'admin.app-eval.approve-feedback',
                { id: this.props.application.id }
            )
        );

        this.setState({
            approved: true,
        });
    }

    collapseFeedbackPm = () => {
        const { showFeedbackPm } = this.state;

        this.setState({
            showFeedbackPm: showFeedbackPm ? false : true,
        })
    }

    render() {
        const { application } = this.props;
        const { modal } = this.state;

        const verdictClass = application.verdict && `app-card--${application.verdict}`

        return (
            <div>
                {modal &&
                    <Modal
                        title={
                            <>application evaluation - <a href={`https://osu.ppy.sh/users/${application.user.osu_id}`} target="_blank">{application.user.username}</a></>
                        }
                        content={this.renderModalContent()}
                        close={this.switchModal}
                    />
                }

                <div className={`app-card ${verdictClass}`} onClick={this.switchModal}>
                    <div className="app-card__name">
                        {application.user.username}
                    </div>

                    <div className="app-card__info">
                        {`applied at ${application.created_at}`}
                    </div>

                    <div className="app-card__info">
                        {`gamemode: ${application.gamemode}`}
                    </div>

                    <div className="app-card__info">
                        {`verdict: ${application.verdict ?? 'not set'}`}
                    </div>
                </div>
            </div>
        )
    }

    renderApproveButton() {
        return (
            <form onSubmit={this.approveFeedback}>
                <button className="dark-form__button dark-form__button--top" type="submit">
                    <i className="fa fa-check" /> Approve feedback!
                </button>
            </form>
        );
    }

    renderCheckboxAnswer(answer: Answer) {
        const childClass = answer.question.relation === 'child' ? 'app-answer--child' : '';

        return (
            <div className={`app-answer app-answer__checkbox ${childClass} app-answer__checkbox--${answer.answer}`}>
                {answer.question.question}
            </div>
        )
    }

    renderInputOrTextareaAnswer(answer: Answer) {
        return (
            <div className={`app-answer ${answer.question.relation === 'child' ? 'app-answer--child' : ''}`}>
                <div className="app-answer__header">{answer.question.question}</div>
                <div className="app-answer__textarea">
                    <Linkify>
                        {answer.answer}
                    </Linkify>
                </div>
            </div>
        )
    }

    renderModalContent() {
        const { application } = this.props;
        const { approved } = this.state;

        const sortedQuestions = application.answers.sort((x, y) => x.question.order - y.question.order);

        return (
            <div>
                <div className="dark-section dark-section--4">
                    {sortedQuestions.map(answer => {
                        switch (answer.question.type) {
                            case 'checkbox':
                                return this.renderCheckboxAnswer(answer);

                            case 'input':
                                return this.renderInputOrTextareaAnswer(answer);

                            case 'textarea':
                                return this.renderInputOrTextareaAnswer(answer);
                        }
                    })}
                </div>

                <div className="dark-section dark-section--3">
                    {approved ? this.renderVerdictInfoField() : this.renderVerdictField()}
                    {(authUser.is_admin && application.feedback && !approved) && this.renderApproveButton()}
                </div>
            </div>
        )
    }

    renderStatus() {
        const { feedback_author, verdict } = this.state;

        return (
            <span>
                {verdict &&
                    <span className="info-badge">
                        <span className={verdict === 'pass' ? 'text-success' : 'text-danger'}>
                            {verdict}
                        </span>
                    </span>
                }

                {feedback_author &&
                    <i className="text-lightgray">
                        {` written by ${feedback_author.username}`}
                    </i>
                }
            </span>
        );
    }

    renderVerdictField() {
        const { application } = this.props;
        const { feedback } = this.state;
        const buttonText = application.verdict ? 'Update' : 'Submit';

        return (
            <>
                <form onSubmit={this.storeFeedback}>
                    <textarea
                        className="dark-form__textarea"
                        rows={7}
                        id="feedback"
                        placeholder="write feedback here..."
                        defaultValue={feedback}
                    />

                    <div className="form--top space-between">
                        <span>
                            {this.renderStatus()}
                        </span>

                        <div>
                            <select id="verdict" className="dark-form__select">
                                <option>fail</option>
                                <option>pass</option>
                            </select>

                            <button type="submit" className="dark-form__button dark-form__button--left">
                                <i className="fa fa-check" /> {buttonText}!
                            </button>
                        </div>
                    </div>
                </form>
            </>
        );
    }

    renderVerdictInfoField() {
        const { feedback, showFeedbackPm, verdict } = this.state;
        const show = showFeedbackPm ? 'show' : '';

        return (
            <div>
                <h5>Feedback</h5>
                <div className="dark-section">
                    {feedback}
                </div>

                {this.renderStatus()} <hr />

                <a
                    href="#"
                    className="text-lightgray"
                    onClick={() => this.collapseFeedbackPm()}
                >
                    click to {showFeedbackPm ? 'hide' : 'show'} feedback pm
                </a>

                <div id="feedbackMessage" className={`dark-section collapse ${show}`}>
                    <AppResultsMessage
                        feedback={feedback ?? ''}
                        verdict={verdict ?? 'fail'}
                    />
                </div>
            </div>
        );
    }

    storeFeedback = async (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        const feedback = (document.getElementById('feedback') as HTMLTextAreaElement).value;
        const verdict = (document.getElementById('verdict') as HTMLSelectElement).value;

        const res = await Axios.post(
            laroute.route('admin.app-eval.store-feedback', { id: this.props.application.id }), {
                feedback: feedback,
                verdict: verdict,
            }
        );

        const data = res.data;

        this.setState({
            feedback: data.feedback,
            feedback_author: data.feedback_author,
            verdict: data.verdict,
        });
    }

    switchModal = () => {
        const { modal } = this.state;

        this.setState({ modal: modal ? false : true});
    }
}

export default AppCard;
