FROM debian:latest
EXPOSE 8080
WORKDIR /tmp/waf
RUN apt-get update && apt-get upgrade -y && apt-get install -y build-essential git libpcre3-dev
RUN git clone https://github.com/CoolerVoid/raptor_waf.git
WORKDIR /tmp/waf/raptor_waf
RUN printf 'CREATE.*\ncreate.*\nALIAS.*\nalias.*' > config/regex_rules.txt
RUN make
ENTRYPOINT bin/Raptor -h h2database -p 4444 -r 8080 -w 0 -o /tmp/loglog.txt -m pcre
