import React from 'react';
import Modal from './modal';
import Axios from 'axios';
import AppResultsMessage from './app-results-message';

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

        console.log(laroute.route(
            'admin.app-eval.approve-feedback',
            { id: this.props.application.id }
        ));

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
        return (
            <div>
                {modal &&
                    <Modal
                        title={`application evaluation - ${application.user.username}`}
                        content={this.renderModalContent()}
                        close={this.switchModal}
                    />
                }

                <div className="app-card" onClick={this.switchModal}>
                    <div className="app-card__name">
                        {application.user.username}
                    </div>

                    <div className="app-card__info">
                        {`applied at ${application.created_at}`}
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

    renderModalContent() {
        const { application } = this.props;
        const { approved } = this.state;

        return (
            <div>
                {application.answers.map(answer => {
                    return <>
                        <h5>{answer.question}</h5>
                        <div className="dark-section">
                            {answer.answer}
                        </div>
                    </>
                })}

                <hr />

                {approved ? this.renderVerdictInfoField() : this.renderVerdictField()}
                {(authUser.is_admin && application.feedback && !approved) && this.renderApproveButton()}
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
                    <div className="textarea-border">
                        <textarea id="feedback" placeholder="write feedback here...">{feedback}</textarea>
                    </div>

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
                    click to load feedback pm
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
