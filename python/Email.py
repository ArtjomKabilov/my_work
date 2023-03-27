import logging
import smtplib
from email.mime.text import MIMEText
from pysnmp.entity import engine, config
from pysnmp.handlers import SyslogHandler
from pysnmp.smi import view, error
def main():
    # Configure SMTP server and email settings
    smtp_server = 'smtp.live.com'
    smtp_port = 587
    smtp_user = 'irina1223148@hotmail.com'
    smtp_password = 'Amonra6657'
    sender_email = 'irina1223148@hotmail.com'
    recipient_email = 'irina1223148@hotmail.com'
    subject = 'Switch Log Notification'

    # Configure SNMP engine and handler
    snmpEngine = engine.SnmpEngine()
    syslogHandler = SyslogHandler()
    syslogHandler.setFormatter(
        logging.Formatter('%(asctime)s %(levelname)s: %(message)s'))
    snmpEngine.registerHandler(syslogHandler)

    # Configure syslog target address and SNMP community
    config.addV1System(snmpEngine, 'my-community', 'public')
    config.addTargetParams(snmpEngine, 'my-creds', 'my-community', 'noAuthNoPriv', 0)
    config.addTargetAddr(
        snmpEngine, 'syslog-server', config.snmpUDPDomain, ('smtp.live.com', 587), 'my-creds', tagList='syslog')

    # Register to send syslog messages to target address
    mibBuilder = snmpEngine.getMibBuilder()
    mibView = view.MibViewController(mibBuilder)
    mibView.addSysOREntry((1,3,6,1,4,1,52,5,1,4,1), ('My organization', 'My contact info', ''))
    config.addSyslogTransport(snmpEngine, 'syslog', mibView, ('smtp.live.com', 587), '')

    # Start SNMP engine
    snmpEngine.transportDispatcher.jobStarted(1)

    # Log messages
    log.info('Switch log notification')

    # Stop SNMP engine
    snmpEngine.transportDispatcher.jobFinished(1)

    # Send email with switch logs
    with open('/var/log/messages', 'r') as f:
        log_text = f.read()
    msg = MIMEText(log_text)
    msg['Subject'] = subject
    msg['From'] = sender_email
    msg['To'] = recipient_email
    smtp_conn = smtplib.SMTP(smtp_server, smtp_port)
    smtp_conn.ehlo()
    smtp_conn.starttls()
    smtp_conn.login(smtp_user, smtp_password)
    smtp_conn.sendmail(sender_email, recipient_email, msg.as_string())
    smtp_conn.quit()
if __name__ == '__main__':
 try:
    main()
 except SystemExit:
    pass