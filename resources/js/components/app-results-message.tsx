import React from 'react';

interface Props {
    feedback: string,
    verdict: 'fail' | 'pass',
}

class AppResultsMessage extends React.PureComponent<Props> {
    failMessage() {
        return (
            <samp>
                Hello, <br /> <br />

                Unfortunately we have to notify you that you didn't make it for osu! spotlights team. <br /> <br />

                {this.renderFeedbackField()}

                Even though your application was rejected, you are more than welcome to try again in the next cycle!

                If you have any questions regarding the process, feel free to reply to this message. <br /> <br />

                With regards, <br />
                {authUser.username}
            </samp>
        );
    }

    renderFeedbackField() {
        return (
            <>
                [b]Additional feedback from managers:[/b]
                [notice]{this.props.feedback}[/notice]
                <br /> <br />
            </>
        );
    }

    passMessage() {
        return (
            <samp>
                Hello, <br /> <br />

                On behalf of osu! spotlights team, we'd like to invite you to join our team! <br /> <br />

                {this.renderFeedbackField()}

                Please let us know whether you'd like to accept or decline the invitation by replying to this PM. <br /> <br />

                With regards, <br />
                {authUser.username}
            </samp>
        );
    }

    render() {
        return (
            <div>
                {this.props.verdict === 'pass'
                    ? this.passMessage()
                    : this.failMessage()
                }
            </div>
        )
    }
}

export default AppResultsMessage;
