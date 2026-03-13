package sn.dakarterminal.dt.service;

import lombok.RequiredArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.stereotype.Service;

@Slf4j
@Service
@RequiredArgsConstructor
public class AuditService {

    public void log(String action, String entityType, Long entityId, String details) {
        String user = getCurrentUser();
        log.info("AUDIT | user={} | action={} | entity={} | id={} | details={}",
                user, action, entityType, entityId, details);
    }

    public void logCreate(String entityType, Long entityId) {
        log("CREATE", entityType, entityId, null);
    }

    public void logUpdate(String entityType, Long entityId, String changes) {
        log("UPDATE", entityType, entityId, changes);
    }

    public void logDelete(String entityType, Long entityId) {
        log("DELETE", entityType, entityId, null);
    }

    public void logLogin(String email) {
        log.info("AUDIT | user={} | action=LOGIN", email);
    }

    public void logLogout(String email) {
        log.info("AUDIT | user={} | action=LOGOUT", email);
    }

    private String getCurrentUser() {
        Authentication auth = SecurityContextHolder.getContext().getAuthentication();
        if (auth != null && auth.isAuthenticated()) {
            return auth.getName();
        }
        return "SYSTEM";
    }
}
